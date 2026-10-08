# Security Hardening Plan — 2026-10-08

Source: `docs/security/2026-10-08-security-review.md`. The review found no vulnerabilities. This plan covers only the hardening items from its appendix, in order of value. Each step is one small commit with one test.

## Step 1: Webhook verifier robustness (`src/Webhooks/WebhookSignatureVerifier.php`)

- `verify()`: call `$body->rewind()` **before** `getContents()` so the whole body is always verified.
- `unwrap()`: verify and decode the **same** `$payload` string (read once). Simplest way: have `verify()` return the payload string it verified (`: string`), and have `unwrap()` use that return value.
- `verifySignature()`: inside the loop, skip entries that don't split into exactly two parts:
  ```php
  $parts = explode(',', $versionedSignature, 2);
  if (count($parts) !== 2 || $parts[0] !== 'v1') { continue; }
  if (hash_equals($expectedSignature, $parts[1])) { return; }
  ```
- `verifyTimestamp()`: before the cast, throw `WebhookVerificationException::invalidTimestamp()` when `! ctype_digit($timestampHeader)`.

**Tests** (`tests/Webhooks/`): partly-read body still verifies; `webhook-signature: garbage` throws `WebhookVerificationException`; `webhook-timestamp: 17e8` throws.

## Step 2: Encode IDs in request paths

- `src/ValueObjects/ResourceUri.php`: wrap `$id` in `rawurlencode()` in `retrieve`, `modify`, `retrieveContent`, `cancel` and `delete`.
- Resources that insert IDs into the `$resource` string or into `Payload::*` URIs (e.g. `Uploads.php:47,64`, `RealtimeCalls`, `FineTuningCheckpoints`, `Organization*`, `ChatkitThreads`, `EvalsRuns`): apply `rawurlencode()` to each ID at the point where it is inserted. Find them with `rg '\{\$\w+Id\}|\{\$id\}' src/Resources`.
- OpenAI IDs are `[A-Za-z0-9_-]`, so `rawurlencode` leaves them unchanged. Fixtures and existing tests should still pass.

**Test:** one test asserting that `ResourceUri::retrieve('files', '../x?y', '')->toString()` gives `files/..%2Fx%3Fy`.

## Step 3: Docs note on replay

Add a short note to the README webhooks section: deduplicate on the `webhook-id` header (e.g. store recent IDs for the 300s tolerance window).

## Out of scope

- A built-in replay cache. It needs a storage dependency; add it if users ask for one.
