# Core API Guides & Usage Manual

This guide covers all key resources available on `OpenAI\Client`.

---

## Table of Contents
- [Responses API](#responses-api)
- [Chat Completions](#chat-completions)
- [Conversations & Items](#conversations--items)
- [Containers & Code Interpreter](#containers--code-interpreter)
- [Skills & Versions](#skills--skill-versions)
- [Audio (Speech, Transcription, Voice Consents & Voices)](#audio)
- [Images (DALL·E)](#images)
- [Embeddings](#embeddings)
- [Vector Stores & File Batches](#vector-stores)
- [Uploads (Multipart Chunked)](#uploads)
- [Files](#files)
- [Batches](#batches)
- [Fine-Tuning & Checkpoints](#fine-tuning)
- [Moderations](#moderations)
- [Realtime (Sessions, Calls & Client Secrets)](#realtime)
- [Evals & Runs](#evals)
- [Chatkit (Beta)](#chatkit-beta)
- [Organization Administration](#organization-administration)

---

## Responses API

The Responses API is OpenAI's stateful, multimodal interface that handles tool orchestration (such as Web Search, File Search, and Code Interpreter) in a unified flow.

### Create Response

```php
$response = $client->responses()->create([
    'model' => 'gpt-4o',
    'input' => 'Find the latest news about PHP 8.4 release features',
    'tools' => [
        ['type' => 'web_search_preview'],
    ],
]);

echo $response->outputText;
echo $response->id;
```

### Streamed Response

```php
$stream = $client->responses()->createStreamed([
    'model' => 'gpt-4o',
    'input' => 'Write a story about a space explorer.',
]);

foreach ($stream as $chunk) {
    if (isset($chunk->delta->text)) {
        echo $chunk->delta->text;
    }
}
```

### Retrieve, Cancel, List Input Items, and Delete

```php
// Retrieve details
$response = $client->responses()->retrieve('resp_123');

// Cancel in-flight response
$client->responses()->cancel('resp_123');

// List input items
$items = $client->responses()->listInputItems('resp_123', ['limit' => 10]);

// Delete response
$client->responses()->delete('resp_123');
```

### Compact Conversation History

Compacts long conversation turns into encrypted compaction objects to save context tokens.

```php
$compacted = $client->responses()->compact([
    'model' => 'gpt-4o',
    'input' => 'Very long conversation text or message objects...',
]);

$compactId = $compacted->id; // 'resp_compact_...'
$totalTokens = $compacted->usage->totalTokens;
```

### Input Tokens Inspection

Calculates token counts for inputs before generating a response.

```php
$tokens = $client->responses()->inputTokens([
    'model' => 'gpt-4o',
    'input' => 'Calculate token count for this prompt.',
]);

echo $tokens->inputTokens; // e.g. 42
```

---

## Chat Completions

Standard endpoint for conversation completions.

### Creating a Chat Completion

```php
$response = $client->chat()->create([
    'model' => 'gpt-4o',
    'messages' => [
        ['role' => 'system', 'content' => 'You are an expert PHP architect.'],
        ['role' => 'user', 'content' => 'How should I structure a DDD project in Laravel?'],
    ],
    'temperature' => 0.7,
]);

echo $response->choices[0]->message->content;
```

### Retrieving a Chat Completion

Retrieve an existing chat completion by ID.

```php
$response = $client->chat()->retrieve('chatcmpl-123');

echo $response->id; // 'chatcmpl-123'
echo $response->choices[0]->message->content;
```

### Streaming Chat Completions

```php
$stream = $client->chat()->createStreamed([
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'user', 'content' => 'Provide a checklist for secure API development.'],
    ],
]);

foreach ($stream as $response) {
    $text = $response->choices[0]->delta->content;
    if ($text !== null) {
        echo $text;
    }
}
```

---

## Conversations & Items

Manage persisted conversation state across Response API requests.

### Manage Conversations

```php
// Create conversation
$conversation = $client->conversations()->create([
    'metadata' => ['user_id' => 'usr_42'],
]);
$conversationId = $conversation->id;

// Retrieve conversation
$details = $client->conversations()->retrieve($conversationId);

// Update metadata
$client->conversations()->modify($conversationId, [
    'metadata' => ['status' => 'archived'],
]);

// Delete conversation
$client->conversations()->delete($conversationId);
```

### Conversation Items

```php
// Add an item to conversation
$item = $client->conversations()->items($conversationId)->create([
    'type' => 'message',
    'role' => 'user',
    'content' => 'Remember that my preferred language is PHP.',
]);

// List items
$items = $client->conversations()->items($conversationId)->list(['limit' => 20]);

// Retrieve specific item
$item = $client->conversations()->items($conversationId)->retrieve('item_123');

// Delete item
$client->conversations()->items($conversationId)->delete('item_123');
```

---

## Containers & Code Interpreter

Create sandboxed execution environments for running code interpreter tasks.

### Manage Containers

```php
// Create a container
$container = $client->containers()->create([
    'name' => 'analytics-sandbox',
]);

// Retrieve container
$info = $client->containers()->retrieve($container->id);

// List containers
$list = $client->containers()->list(['limit' => 10]);

// Delete container
$client->containers()->delete($container->id);
```

### Container Files

```php
// Upload a file to container
$file = $client->containers()->files($container->id)->create([
    'file' => fopen('dataset.csv', 'r'),
]);

// List container files
$files = $client->containers()->files($container->id)->list();

// Retrieve file metadata
$fileMeta = $client->containers()->files($container->id)->retrieve($file->id);

// Delete file
$client->containers()->files($container->id)->delete($file->id);
```

---

## Skills & Skill Versions

Manage reusable custom tools/skills for shell and response tooling.

### Manage Skills

```php
// Upload/create a skill bundle
$skill = $client->skills()->create([
    'name' => 'Data Transformer',
    'files' => [
        fopen('script.py', 'r'),
    ],
]);

// List skills
$skills = $client->skills()->list();

// Retrieve a skill
$skill = $client->skills()->retrieve($skill->id);

// Delete a skill
$client->skills()->delete($skill->id);
```

### Skill Versions

```php
// Create version
$version = $client->skills()->versions($skill->id)->create([
    'files' => [
        fopen('script_v2.py', 'r'),
    ],
]);

// List versions
$versions = $client->skills()->versions($skill->id)->list();

// Retrieve version
$version = $client->skills()->versions($skill->id)->retrieve('ver_123');
```

---

## Audio

Interact with audio generation, speech-to-text, and translation.

### Text to Speech (TTS)

```php
$audio = $client->audio()->speech([
    'model' => 'tts-1',
    'input' => 'Welcome to the OpenAI PHP client documentation!',
    'voice' => 'alloy',
]);

file_put_contents('welcome.mp3', $audio);
```

### Audio Transcription

```php
$transcription = $client->audio()->transcribe([
    'model' => 'whisper-1',
    'file' => fopen('recording.mp3', 'r'),
    'response_format' => 'verbose_json',
]);

echo $transcription->text;
```

### Audio Translation

```php
$translation = $client->audio()->translate([
    'model' => 'whisper-1',
    'file' => fopen('german_speech.mp3', 'r'),
]);

echo $translation->text;
```

### Voice Consents

Create and manage voice consent recordings required before creating custom voices.

```php
// Create consent record
$consent = $client->audio()->voiceConsents()->create([
    'name' => 'Jane Doe',
    'language' => 'en-US',
    'recording' => fopen('consent_recording.mp3', 'r'),
]);

// List and retrieve consents
$consents = $client->audio()->voiceConsents()->list();
$details = $client->audio()->voiceConsents()->retrieve($consent->id);

// Update or delete consent
$client->audio()->voiceConsents()->update($consent->id, ['name' => 'Jane Doe Updated']);
$client->audio()->voiceConsents()->delete($consent->id);
```

### Custom Voices

Create custom voices with user consent and sample audio recordings.

```php
$voice = $client->audio()->voices()->create([
    'name' => 'Brand Spokesperson Voice',
    'consent' => $consent->id,
    'audio_sample' => fopen('voice_sample.mp3', 'r'),
]);

echo $voice->id; // 'voice_1234'
```

---

## Images

Generate, edit, and create variations using DALL·E.

### Generate Images

```php
$response = $client->images()->create([
    'model' => 'dall-e-3',
    'prompt' => 'Futuristic server room with glowing neon blue cables, photorealistic',
    'n' => 1,
    'size' => '1024x1024',
    'quality' => 'hd',
]);

echo $response->data[0]->url;
```

### Image Edit & Variation

```php
// Edit
$response = $client->images()->edit([
    'image' => fopen('image.png', 'r'),
    'mask' => fopen('mask.png', 'r'),
    'prompt' => 'Add a small robotic cat sitting on the chair',
    'size' => '1024x1024',
]);

// Variation
$response = $client->images()->variation([
    'image' => fopen('logo.png', 'r'),
    'n' => 2,
    'size' => '512x512',
]);
```

---

## Embeddings

Calculate high-dimensional numerical vectors for semantic search and clustering.

```php
$response = $client->embeddings()->create([
    'model' => 'text-embedding-3-small',
    'input' => 'PHP design patterns and clean architecture',
]);

$vector = $response->embeddings[0]->embedding; // array of floats
```

---

## Vector Stores

Manage Vector Stores and File Batches for file search.

```php
// Create store
$store = $client->vectorStores()->create([
    'name' => 'API Docs Knowledgebase',
]);

// Attach files
$storeFile = $client->vectorStores()->files($store->id)->create([
    'file_id' => 'file-abc123xyz',
]);

// Batch upload to store
$batch = $client->vectorStores()->fileBatches($store->id)->create([
    'file_ids' => ['file-1', 'file-2'],
]);

// Check batch status
$status = $client->vectorStores()->fileBatches($store->id)->retrieve($batch->id);
```

---

## Files

Upload, retrieve, and delete files stored on OpenAI's servers.

```php
// Upload for fine-tuning or assistants
$file = $client->files()->upload([
    'purpose' => 'fine-tune',
    'file' => fopen('training_data.jsonl', 'r'),
]);

// List files
$files = $client->files()->list();

// Retrieve file content
$contents = $client->files()->download($file->id);

// Delete file
$client->files()->delete($file->id);
```

---

## Batches

Execute large batches of API calls asynchronously with 24-hour turnaround and reduced cost.

```php
$batch = $client->batches()->create([
    'input_file_id' => 'file-input-batch-123',
    'endpoint' => '/v1/chat/completions',
    'completion_window' => '24h',
]);

// Poll status
$status = $client->batches()->retrieve($batch->id);

// Cancel if needed
$client->batches()->cancel($batch->id);
```

---

## Fine-Tuning

Tailor models with custom training datasets.

```php
$job = $client->fineTuning()->createJob([
    'training_file' => 'file-training-xyz',
    'model' => 'gpt-4o-mini-2024-07-18',
]);

// List checkpoints
$checkpoints = $client->fineTuning()->listJobCheckpoints($job->id);

// Cancel job
$client->fineTuning()->cancel($job->id);
```

---

## Moderations

Classify text against OpenAI's usage policies.

```php
$result = $client->moderations()->create([
    'model' => 'omni-moderation-latest',
    'input' => 'Sample text to review...',
]);

$flagged = $result->results[0]->flagged; // bool
$categories = $result->results[0]->categories;
```

---

## Uploads

Upload large files (>100MB up to 512MB) in multiple parts for fine-tuning or assistants.

```php
// 1. Create upload session
$upload = $client->uploads()->create([
    'filename' => 'large_dataset.jsonl',
    'purpose' => 'fine-tune',
    'bytes' => 104857600,
    'mime_type' => 'text/jsonl',
]);

// 2. Upload chunk parts
$part = $client->uploads()->uploadPart(
    uploadId: $upload->id,
    parameters: [
        'data' => fopen('chunk_part_1.bin', 'r'),
    ]
);

// 3. Complete upload
$completed = $client->uploads()->complete(
    uploadId: $upload->id,
    parameters: [
        'part_ids' => [$part->id],
    ]
);

echo $completed->file->id; // File is ready for use

// Or cancel if aborted
// $client->uploads()->cancel($upload->id);
```

---

## Files

Upload, retrieve, and delete files stored on OpenAI's servers.

```php
// Upload for fine-tuning or assistants
$file = $client->files()->upload([
    'purpose' => 'fine-tune',
    'file' => fopen('training_data.jsonl', 'r'),
]);

// List files
$files = $client->files()->list();

// Retrieve file content
$contents = $client->files()->download($file->id);

// Delete file
$client->files()->delete($file->id);
```

---

## Batches

Execute large batches of API calls asynchronously with 24-hour turnaround and reduced cost.

```php
$batch = $client->batches()->create([
    'input_file_id' => 'file-input-batch-123',
    'endpoint' => '/v1/chat/completions',
    'completion_window' => '24h',
]);

// Poll status
$status = $client->batches()->retrieve($batch->id);

// Cancel if needed
$client->batches()->cancel($batch->id);
```

---

## Fine-Tuning

Tailor models with custom training datasets and manage checkpoint permissions across projects.

```php
$job = $client->fineTuning()->createJob([
    'training_file' => 'file-training-xyz',
    'model' => 'gpt-4o-mini-2024-07-18',
]);

// List checkpoints for the job
$checkpoints = $client->fineTuning()->listJobCheckpoints($job->id);

// Manage checkpoint permissions across organization projects
$permission = $client->fineTuning()->checkpoints()->createPermission('ftckpt_123', [
    'project_ids' => ['proj_456'],
]);
$client->fineTuning()->checkpoints()->deletePermission('ftckpt_123', $permission->data[0]->id);

// Cancel job
$client->fineTuning()->cancel($job->id);
```

---

## Moderations

Classify text against OpenAI's usage policies.

```php
$result = $client->moderations()->create([
    'model' => 'omni-moderation-latest',
    'input' => 'Sample text to review...',
]);

$flagged = $result->results[0]->flagged; // bool
$categories = $result->results[0]->categories;
```

---

## Realtime

Interact with the Realtime API for ultra-low latency voice/multimodal sessions, SIP/WebRTC call orchestration, and client secrets.

### Sessions & Tokens

```php
// Create ephemeral session token for browser or mobile client
$session = $client->realtime()->token([
    'model' => 'gpt-4o-realtime-preview',
]);
$ephemeralToken = $session->clientSecret->value;

// Ephemeral token for transcription
$transcribe = $client->realtime()->transcribeToken();
```

### Realtime Calls

Initiate and control active SIP/WebRTC calls.

```php
// Create call
$call = $client->realtime()->calls()->create([
    'session' => ['model' => 'gpt-4o-realtime-preview'],
]);

// Retrieve call
$callDetails = $client->realtime()->calls()->retrieve($call->id);

// Accept, refer, or hang up call
$client->realtime()->calls()->accept($call->id);
$client->realtime()->calls()->refer($call->id, ['target' => 'sip:support@domain.com']);
$client->realtime()->calls()->hangup($call->id);
```

### Realtime Client Secrets

Create ephemeral client secrets for browser connections with restricted lifetimes.

```php
$secret = $client->realtime()->clientSecrets()->create([
    'session' => [
        'model' => 'gpt-4o-realtime-preview',
        'voice' => 'alloy',
    ],
]);

echo $secret->value;
```

---

## Evals

Create, execute, and monitor model evaluations and eval runs to track benchmark performance.

### Manage Evaluations

```php
// Create evaluation
$eval = $client->evals()->create([
    'name' => 'customer-support-eval',
    'description' => 'Evaluates support response tone and accuracy',
]);

// Retrieve & update
$evalDetails = $client->evals()->retrieve($eval->id);
$client->evals()->modify($eval->id, ['description' => 'Updated description']);

// List & delete
$evalList = $client->evals()->list();
$client->evals()->delete($eval->id);
```

### Evaluation Runs

```php
// Create an evaluation run
$run = $client->evals()->runs()->create(
    evalId: 'eval_123',
    parameters: [
        'model' => 'gpt-4o',
    ]
);

// Retrieve & list runs
$runDetails = $client->evals()->runs()->retrieve('eval_123', $run->id);
$runs = $client->evals()->runs()->list('eval_123');

// Delete run
$client->evals()->runs()->delete('eval_123', $run->id);
```

---

## Chatkit (Beta)

Interact with OpenAI Chatkit conversational workflows, user sessions, and chat threads.

### Sessions

```php
// Create a client session token
$session = $client->chatkit()->sessions()->create([
    'workflow_id' => 'wf_abc123',
    'user' => 'user_42',
]);

$clientSecret = $session->clientSecret;
```

### Threads & Items

```php
// Create and retrieve thread
$thread = $client->chatkit()->threads()->create([
    'workflow_id' => 'wf_abc123',
]);
$threadDetails = $client->chatkit()->threads()->retrieve($thread->id);

// List thread items (messages)
$items = $client->chatkit()->threads()->items()->list(
    threadId: $thread->id,
    parameters: ['limit' => 20],
);

// Delete thread
$client->chatkit()->threads()->delete($thread->id);
```

---

## Organization Administration

Manage organization-level audit logs, user invites, team members, projects, and administrative API keys. Requires an Organization Admin Key (`sk-admin-...`).

### Audit Logs

```php
$logs = $client->organization()->auditLogs()->list([
    'limit' => 50,
]);

foreach ($logs->data as $log) {
    echo $log->type . ' by ' . $log->actor->type;
}
```

### Invites & Users

```php
// Send invitation
$invite = $client->organization()->invites()->create([
    'email' => 'engineer@example.com',
    'role' => 'reader',
]);
$client->organization()->invites()->delete($invite->id);

// Manage existing users
$users = $client->organization()->users()->list();
$user = $client->organization()->users()->retrieve('user_123');
$client->organization()->users()->modify('user_123', ['role' => 'owner']);
$client->organization()->users()->delete('user_123');
```

### Projects & Admin API Keys

```php
// Projects
$project = $client->organization()->projects()->create(['name' => 'Internal AI Sandbox']);
$projects = $client->organization()->projects()->list();
$client->organization()->projects()->archive($project->id);

// Admin API Keys
$adminKey = $client->organization()->adminApiKeys()->create(['name' => 'CI Deployment Key']);
$keys = $client->organization()->adminApiKeys()->list();
$client->organization()->adminApiKeys()->delete($adminKey->id);
```

