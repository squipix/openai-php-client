# OpenAI API Compatibility Report

**Library:** `squipix/openai-php-client`  
**Date:** 2026-09-30  
**Compared against:** [OpenAI API Reference](https://developers.openai.com/api/reference/llms.txt) (live, September 2026)

---

## Summary

The library covers the **core OpenAI API endpoints** well and is largely compatible with the most commonly used surfaces. However, there are several **missing endpoints** (mostly newer or admin-scoped), a few **deprecated leftovers**, and one **missing method** on an existing resource.

| Category | Status |
|---|---|
| Core API endpoints (Responses, Chat, Completions, Embeddings, Models, etc.) | ✅ Fully covered |
| Newer API features (Containers, Skills, Conversations, Webhooks) | ✅ Covered |
| Streaming & SSE support | ✅ Covered |
| Responses API tool output models | ✅ Rich coverage (20+ output types) |
| Missing newer endpoints | ⚠️ Several gaps (see below) |
| Deprecated/removed endpoints still present | ⚠️ 2 endpoints |

---

## ✅ Covered Endpoints

These endpoints are implemented and align with the current OpenAI API:

| OpenAI API Endpoint | Library Resource | Methods |
|---|---|---|
| **Responses** (`/responses`) | [Responses.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Responses.php) | create, createStreamed, retrieve, retrieveStreamed, cancel, delete, list (input_items) |
| **Chat Completions** (`/chat/completions`) | [Chat.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Chat.php) | create, createStreamed |
| **Completions** (`/completions`) | [Completions.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Completions.php) | create, createStreamed |
| **Embeddings** (`/embeddings`) | [Embeddings.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Embeddings.php) | create |
| **Models** (`/models`) | [Models.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Models.php) | list, retrieve, delete |
| **Files** (`/files`) | [Files.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Files.php) | list, retrieve, download, upload, delete |
| **Images** (`/images`) | [Images.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Images.php) | create, createStreamed, edit, editStreamed, variation |
| **Audio** (`/audio`) | [Audio.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Audio.php) | speech, speechStreamed, transcribe, transcribeStreamed, translate |
| **Moderations** (`/moderations`) | [Moderations.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Moderations.php) | create |
| **Fine-Tuning** (`/fine_tuning`) | [FineTuning.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/FineTuning.php) | createJob, listJobs, retrieveJob, cancelJob, listJobEvents |
| **Batches** (`/batches`) | [Batches.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Batches.php) | create, retrieve, cancel, list |
| **Assistants** (`/assistants`) | [Assistants.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Assistants.php) | create, retrieve, modify, delete, list |
| **Threads** (`/threads`) | [Threads.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Threads.php) | Full coverage (messages, runs, steps) |
| **Vector Stores** (`/vector_stores`) | [VectorStores.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/VectorStores.php) | create, list, retrieve, modify, delete, search, files, batches |
| **Containers** (`/containers`) | [Containers.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Containers.php) | create, retrieve, delete, list, files (CRUD + content) |
| **Conversations** (`/conversations`) | [Conversations.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Conversations.php) | create, retrieve, update, delete, items (CRUD) |
| **Skills** (`/skills`) | [Skills.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Skills.php) | create, list, retrieve, update, content, delete, versions |
| **Realtime Sessions** (`/realtime/sessions`) | [Realtime.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Realtime.php) | token, transcribeToken |
| **Webhooks** | [WebhookSignatureVerifier.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Webhooks/WebhookSignatureVerifier.php) | verify, sign |

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

## ⚠️ Missing Endpoints & Methods

These exist in the current OpenAI API reference but are **not implemented** in the library:

### Missing Method on Existing Resource

| Endpoint | API Method | Notes |
|---|---|---|
| **Responses — Compact** | `POST /responses/compact` | Compacts a long conversation. The library handles `compaction` *output objects* but doesn't expose the `compact` method on the [Responses](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Responses.php) resource. |
| **Chat Completions — Retrieve** | `GET /chat/completions/{id}` | Retrieves a stored chat completion by ID. Not implemented in [Chat.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Chat.php). |

### Missing Entire Endpoint Groups

| OpenAI API Endpoint Group | Notes |
|---|---|
| **Evals** (`/evals`) | Create, list, retrieve, update, delete evaluations and runs. |
| **Graders** (`/graders`) | Evaluation grader definitions. |
| **Uploads** (`/uploads`) | Multipart upload management (create, add parts, complete, cancel). |
| **Audio — Voice Consents** (`/audio/voice_consents`) | Create, list, retrieve, update, delete voice consent records. |
| **Audio — Voices** (`/audio/voices`) | Create custom voices. |
| **Fine-Tuning Checkpoints Permissions** | Manage permissions on fine-tuning checkpoints. |
| **Fine-Tuning Job Checkpoints — List** | List checkpoints for a fine-tuning job. |
| **Realtime Calls** (`/realtime/calls`) | Create, accept, reject, hangup, refer calls. |
| **Realtime Client Secrets** (`/realtime/client_secrets`) | Create client secrets for realtime sessions. |
| **Beta Chatkit** (`/beta/chatkit`) | Sessions and threads for chatkit (beta). |
| **Responses Input Tokens** | Token-level inspection of response inputs. |
| **Live WebSocket** (`/live`) | Primary, sideband, and fork WebSocket connections. |

### Missing Administration Endpoints

| OpenAI API Endpoint Group | Notes |
|---|---|
| **Organization** (`/organization`) | Audit logs, admin API keys, usage, groups, invites, projects, service accounts, users, roles. |
| **Projects** (`/projects`) | Groups, roles, users management. |

> [!NOTE]
> Administration endpoints are typically used for org-level management rather than standard API usage, so their absence may be intentional.

---

## ⚠️ Deprecated / Removed Endpoints Still Present

| Endpoint | Library Resource | Status |
|---|---|---|
| **Edits** (`/edits`) | [Edits.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/Edits.php) | Removed from OpenAI API in Jan 2024. Marked `@deprecated` but still exposed on the client. |
| **Fine-Tunes** (`/fine-tunes`) | [FineTunes.php](file:///d:/dev/php-packages/Squipix/openai-php-client/src/Resources/FineTunes.php) | Removed from OpenAI API in Jan 2024. Marked `@deprecated` but still exposed on the client. |

---

## Compatibility Verdict

> [!IMPORTANT]
> **The library is broadly compatible with the OpenAI API for all mainstream use cases.** The core surface (Responses, Chat, Completions, Embeddings, Audio, Images, Files, Models, Fine-Tuning, Batches, Vector Stores, Containers, Conversations, Skills, Assistants/Threads, Realtime sessions, and Webhooks) is well-covered with rich response typing.

### Key Gaps to Address (Priority Order)

1. **`Responses::compact()`** — Most impactful miss; required for managing long conversations
2. **`Chat::retrieve()`** — Retrieving stored completions is a commonly used feature
3. **Uploads API** — Needed for large file uploads (>100MB)
4. **Evals / Graders** — Growing in importance for production AI systems
5. **Audio Voice Consents / Voices** — Required for custom voice applications
6. **Realtime Calls + Client Secrets** — Required for phone-call-style realtime integrations
7. **Administration APIs** — Lower priority; only needed for org management tools
8. **Cleanup** — Consider removing or hiding the deprecated `Edits` and `FineTunes` resources
