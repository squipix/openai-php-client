# Security Review — 2026-10-08

**Scope:** `squipix/openai-php-client` at `49c0bf7` (`main`). The branch had no pending diff, so the review covered the fork's own changes (`95e6a8e`, `ccb5443`) and the core transport they depend on:

- New resources: Uploads/multipart, Audio voices and voice consents, Chatkit, Evals, Fine-tuning checkpoints, Organization admin APIs, Realtime calls and client secrets, Responses compact/input-tokens
- Webhook verification: `src/Webhooks/WebhookSignatureVerifier.php`
- `src/ValueObjects/ResourceUri.php`, `src/ValueObjects/Transporter/*`, `src/Factory.php`

**Method:** find candidate issues, check each one for false positives, report only findings with confidence of 8/10 or higher.

## Findings

**None at HIGH or MEDIUM severity.** Every candidate came in below the 0.7 confidence threshold, so none went on to the false-positive check.

## Areas verified as sound

| Area | Result |
|---|---|
| Webhook HMAC check | `hash_equals()` gives a constant-time comparison. HMAC-SHA256 is computed over `id.timestamp.rawBody` on the raw bytes (`WebhookSignatureVerifier.php:100,121-126`). |
| Webhook secret | `whsec_` prefix is stripped and the rest is strictly base64-decoded. An invalid or empty secret throws (`:23-28`). |
| Webhook headers | Headers are read case-insensitively through PSR-7. A missing header throws (`:79`). Verification fails closed on every path. |
| Webhook timestamp | ±300s window is enforced in both directions. A non-numeric value becomes `0` and is rejected (`:134-148`). |
| Base URI / host | `BaseUri` always prefixes `https://{host}/v1/`. Resource IDs cannot change the host or the protocol. |
| Multipart | Boundary is generated and escaped by `php-http/multipart-stream-builder`. Field names come from the developer. |
| Headers | Header values come from the developer through the factory. PSR-7 rejects CRLF. |
| Secret exposure | The API key never appears in exceptions, `__toString` or logs. `client_secret` in Chatkit/Realtime `toArray()` is response data the caller asked for. |
| Dangerous sinks | No `unserialize`, `eval`, `exec`, `shell_exec` or `system` in `src/`. |

## Appendix: hardening observations (not vulnerabilities)

1. **Unencoded IDs in request paths.** `ResourceUri.php:51-83` and the new resources (e.g. `Uploads.php:47,64`) insert IDs into the path without encoding them. If an app passes untrusted input as an ID, `../`, `?` or `#` could redirect the request to another path or query on the same OpenAI host. This only changes the path, and OpenAI still checks authorization on the API key, so it is not exploitable as privilege escalation.
2. **Webhook body read position.** `verify()` (`:36-38`) reads from the stream's current position and only rewinds afterwards. If the caller had already partly read the body, the verified bytes would differ from the bytes `unwrap()` decodes after its rewind. This is not exploitable, because a forged tail still needs a valid HMAC.
3. **Malformed signature entry.** An entry without a comma (`:94`) raises an undefined-key warning instead of a `WebhookVerificationException`. It already fails closed.
4. **Replay inside the window.** The library does not deduplicate on `webhook-id`. That is the caller's job under Standard Webhooks, but the docs should say so.
5. **Loose timestamp cast.** The `(int)` cast in `verifyTimestamp` accepts forms like `" 17e8"`. Signing uses the parsed int, so this is not exploitable.

The fix plan is in `docs/plans/2026-10-08-security-hardening-plan.md`.
