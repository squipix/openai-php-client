<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;

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
     * Counts the input tokens of a Messages request without creating it.
     *
     * @see https://docs.claude.com/en/api/messages-count-tokens
     *
     * @param  array<string, mixed>  $parameters
     */
    public function countTokens(array $parameters): CountTokensResponse;
}
