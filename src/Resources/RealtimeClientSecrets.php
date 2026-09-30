<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\RealtimeClientSecretsContract;
use OpenAI\Responses\Realtime\ClientSecrets\ClientSecretResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ClientSecretResponseType from ClientSecretResponse
 */
final class RealtimeClientSecrets implements RealtimeClientSecretsContract
{
    use Concerns\Transportable;

    /**
     * Create an ephemeral client secret for Realtime sessions.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-client-secrets/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ClientSecretResponse
    {
        $payload = Payload::create('realtime/client_secrets', $parameters);

        /** @var Response<ClientSecretResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ClientSecretResponse::from($response->data(), $response->meta());
    }
}
