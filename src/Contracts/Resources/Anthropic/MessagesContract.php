<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\Anthropic\Messages\CreateStreamedResponse;
use OpenAI\Responses\StreamResponse;

interface MessagesContract
{
    /**
     * Sends a structured list of input messages and returns the model's next message.
     * Parameters use the API's snake_case names (`max_tokens`, `cache_control`, ...).
     *
     * @see https://docs.claude.com/en/api/messages
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CreateResponse;

    /**
     * Sends a structured list of input messages and streams the model's next message as server-sent events.
     *
     * @see https://docs.claude.com/en/api/messages-streaming
     *
     * @param  array<string, mixed>  $parameters
     * @return StreamResponse<CreateStreamedResponse>
     */
    public function createStreamed(array $parameters): StreamResponse;

    /**
     * Counts the input tokens of a Messages request without creating it.
     *
     * @see https://docs.claude.com/en/api/messages-count-tokens
     *
     * @param  array<string, mixed>  $parameters
     */
    public function countTokens(array $parameters): CountTokensResponse;
}
