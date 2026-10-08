<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\MessagesContract;
use OpenAI\Resources\Concerns\Streamable;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type CreateResponseType from CreateResponse
 * @phpstan-import-type CountTokensResponseType from CountTokensResponse
 */
final class Messages implements MessagesContract
{
    use Streamable;
    use Transportable;

    /**
     * Sends a structured list of input messages and returns the model's next message.
     *
     * @see https://docs.claude.com/en/api/messages
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CreateResponse
    {
        $this->ensureNotStreamed($parameters);

        $payload = Payload::create('messages', $parameters);

        /** @var Response<CreateResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CreateResponse::from($response->data(), $response->meta());
    }

    /**
     * Counts the input tokens of a Messages request without creating it.
     *
     * @see https://docs.claude.com/en/api/messages-count-tokens
     *
     * @param  array<string, mixed>  $parameters
     */
    public function countTokens(array $parameters): CountTokensResponse
    {
        $payload = Payload::create('messages/count_tokens', $parameters);

        /** @var Response<CountTokensResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CountTokensResponse::from($response->data(), $response->meta());
    }
}
