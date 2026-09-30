# OpenAI API Compatibility Report

**Library:** `squipix/openai-php-client`  
**Date:** 2026-09-30  
**Compared against:** [OpenAI API Reference](https://developers.openai.com/api/reference/llms.txt) (live, September 2026)

---

## Summary

The library has achieved **comprehensive coverage of the OpenAI API endpoints** up to date with the latest live OpenAI API reference (September 2026), including streaming, beta chatkit, multi-part chunked uploads, audio voice consents/custom voices, realtime calls and client secrets, evaluation runs, fine-tuning checkpoints & permissions, and organization-level administration APIs.

| Category | Status |
|---|---|
| Core API endpoints (Responses, Chat, Completions, Embeddings, Models, etc.) | ✅ Fully covered |
| Newer API features (Containers, Skills, Conversations, Webhooks) | ✅ Fully covered |
| Streaming & SSE support | ✅ Fully covered |
| Responses API tool output models & compaction | ✅ Fully covered |
| Large Multipart Uploads (`/uploads`) | ✅ Fully covered |
| Audio Voice Consents & Voices (`/audio/...`) | ✅ Fully covered |
| Evals & Eval Runs (`/evals`) | ✅ Fully covered |
| Realtime Calls, Client Secrets & Sessions (`/realtime/...`) | ✅ Fully covered |
| Fine-Tuning Job Checkpoints & Permissions | ✅ Fully covered |
| Organization Administration & Audit Logs (`/organization/...`) | ✅ Fully covered |
| Beta Chatkit (`/chatkit`) | ✅ Fully covered |
| Deprecated/removed endpoints still present | ⚠️ 2 legacy endpoints retained for backward compatibility |

---

## ✅ Covered Endpoints

These endpoints are implemented and align with the current OpenAI API:

| OpenAI API Endpoint | Library Resource | Methods |
|---|---|---|
| **Responses** (`/responses`) | [Responses.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Responses.php) | create, createStreamed, retrieve, retrieveStreamed, compact, inputTokens, cancel, delete, list (input_items) |
| **Chat Completions** (`/chat/completions`) | [Chat.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Chat.php) | create, createStreamed, retrieve |
| **Completions** (`/completions`) | [Completions.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Completions.php) | create, createStreamed |
| **Embeddings** (`/embeddings`) | [Embeddings.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Embeddings.php) | create |
| **Models** (`/models`) | [Models.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Models.php) | list, retrieve, delete |
| **Files** (`/files`) | [Files.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Files.php) | list, retrieve, download, upload, delete |
| **Uploads** (`/uploads`) | [Uploads.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Uploads.php) | create, uploadPart, complete, cancel |
| **Images** (`/images`) | [Images.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Images.php) | create, createStreamed, edit, editStreamed, variation |
| **Audio** (`/audio`) | [Audio.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Audio.php) | speech, speechStreamed, transcribe, transcribeStreamed, translate, voiceConsents (CRUD), voices (create) |
| **Moderations** (`/moderations`) | [Moderations.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Moderations.php) | create |
| **Fine-Tuning** (`/fine_tuning`) | [FineTuning.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/FineTuning.php) | createJob, listJobs, retrieveJob, cancelJob, listJobEvents, listJobCheckpoints, checkpoints (permissions CRUD) |
| **Batches** (`/batches`) | [Batches.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Batches.php) | create, retrieve, cancel, list |
| **Evals** (`/evals`) | [Evals.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Evals.php) | create, retrieve, modify, list, delete, runs (CRUD) |
| **Realtime** (`/realtime`) | [Realtime.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Realtime.php) | token, transcribeToken, calls (create, retrieve, accept, hangup, refer, reject), clientSecrets (create) |
| **Chatkit (Beta)** (`/chatkit`) | [Chatkit.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Chatkit.php) | sessions (create), threads (CRUD + thread items list) |
| **Organization** (`/organization`) | [Organization.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Organization.php) | auditLogs (list), invites (CRUD), users (CRUD), projects (CRUD + users/service accounts/API keys), adminApiKeys (CRUD) |
| **Assistants** (`/assistants`) | [Assistants.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Assistants.php) | create, retrieve, modify, delete, list |
| **Threads** (`/threads`) | [Threads.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Threads.php) | Full coverage (messages, runs, steps) |
| **Vector Stores** (`/vector_stores`) | [VectorStores.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/VectorStores.php) | create, list, retrieve, modify, delete, search, files, batches |
| **Containers** (`/containers`) | [Containers.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Containers.php) | create, retrieve, delete, list, files (CRUD + content) |
| **Conversations** (`/conversations`) | [Conversations.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Conversations.php) | create, retrieve, update, delete, items (CRUD) |
| **Skills** (`/skills`) | [Skills.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Skills.php) | create, list, retrieve, update, content, delete, versions |
| **Webhooks** | [WebhookSignatureVerifier.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Webhooks/WebhookSignatureVerifier.php) | verify, sign, unwrap |

### Responses API Tool Coverage

The library has excellent coverage of the Responses API output types:

| Output Type | Status |
|---|---|
| OutputMessage (text, refusal) | ✅ |
| OutputFunctionToolCall | ✅ |
| OutputCodeInterpreterToolCall | ✅ |
| OutputFileSearchToolCall | ✅ |
| OutputWebSearchToolCall | ✅ |
| OutputComputerToolCall | ✅ |
| OutputImageGenerationToolCall | ✅ |
| OutputMcpCall / McpApprovalRequest / McpListTools | ✅ |
| OutputReasoning / ReasoningSummary | ✅ |
| OutputCompaction | ✅ |
| OutputApplyPatchToolCall | ✅ |
| OutputLocalShellCall | ✅ |
| OutputProgram / ProgramOutput | ✅ |
| OutputToolSearchCall | ✅ |
| RemoteMcpTool, ToolSearchTool, NamespaceTool, ProgrammaticToolCallingTool, etc. | ✅ |

---

## ⚠️ Deprecated / Removed Endpoints Still Present

| Endpoint | Library Resource | Status |
|---|---|---|
| **Edits** (`/edits`) | [Edits.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Edits.php) | Removed from OpenAI API in Jan 2024. Marked `@deprecated` but retained for backward compatibility. |
| **Fine-Tunes** (`/fine-tunes`) | [FineTunes.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/FineTunes.php) | Removed from OpenAI API in Jan 2024. Marked `@deprecated` but retained for backward compatibility. |

---

## Compatibility Verdict

> [!IMPORTANT]
> **The library provides 100% feature coverage of all modern OpenAI API endpoints and features.** All recently added features—including `Responses::compact()`, `Responses::inputTokens()`, `Chat::retrieve()`, `Uploads`, `AudioVoiceConsents`, `AudioVoices`, `Evals`, `Chatkit`, `RealtimeCalls`, `RealtimeClientSecrets`, Fine-Tuning Checkpoint Permissions, and `Organization` Administration APIs—are fully implemented, strictly typed, and covered with unit and fake-testing suites.
