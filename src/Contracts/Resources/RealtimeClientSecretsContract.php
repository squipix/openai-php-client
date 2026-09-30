<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Realtime\ClientSecrets\ClientSecretResponse;

interface RealtimeClientSecretsContract
{
    /**
     * Create an ephemeral client secret for Realtime sessions.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-client-secrets/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ClientSecretResponse;
}
