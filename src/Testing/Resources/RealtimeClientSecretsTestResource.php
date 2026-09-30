<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\RealtimeClientSecretsContract;
use OpenAI\Resources\RealtimeClientSecrets;
use OpenAI\Responses\Realtime\ClientSecrets\ClientSecretResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class RealtimeClientSecretsTestResource implements RealtimeClientSecretsContract
{
    use Testable;

    protected function resource(): string
    {
        return RealtimeClientSecrets::class;
    }

    public function create(array $parameters = []): ClientSecretResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
