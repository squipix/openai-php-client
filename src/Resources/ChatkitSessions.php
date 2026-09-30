<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\ChatkitSessionsContract;
use OpenAI\Responses\Chatkit\Sessions\SessionResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ChatkitSessionResponseType from SessionResponse
 */
final class ChatkitSessions implements ChatkitSessionsContract
{
    use Concerns\Transportable;

    /**
     * Create a Chatkit session.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/create-session
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): SessionResponse
    {
        $payload = Payload::create('chatkit/sessions', $parameters);

        /** @var Response<ChatkitSessionResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return SessionResponse::from($response->data(), $response->meta());
    }

    /**
     * Cancel an active Chatkit session.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/cancel-session
     */
    public function cancel(string $sessionId): SessionResponse
    {
        $payload = Payload::create("chatkit/sessions/{$sessionId}/cancel", []);

        /** @var Response<ChatkitSessionResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return SessionResponse::from($response->data(), $response->meta());
    }
}
