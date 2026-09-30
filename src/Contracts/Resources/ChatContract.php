<?php

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Responses\Chat\CreateStreamedResponse;
use OpenAI\Responses\StreamResponse;

interface ChatContract
{
    /**
     * Creates a completion for the chat message
     *
     * @see https://platform.openai.com/docs/api-reference/chat/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CreateResponse;

    /**
     * Creates a streamed completion for the chat message
     *
     * @see https://platform.openai.com/docs/api-reference/chat/create
     *
     * @param  array<string, mixed>  $parameters
     * @return StreamResponse<CreateStreamedResponse>
     */
    public function createStreamed(array $parameters): StreamResponse;

    /**
     * Retrieves a stored chat completion with the given ID.
     *
     * @see https://developers.openai.com/api/reference/resources/chat/subresources/completions/methods/retrieve
     */
    public function retrieve(string $id): CreateResponse;
}
