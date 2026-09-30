<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Chatkit\Threads\DeleteThreadResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadItemsResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadsResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadResponse;

interface ChatkitThreadsContract
{
    /**
     * List Chatkit threads.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/list-threads
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListThreadsResponse;

    /**
     * Retrieve a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/retrieve-thread
     */
    public function retrieve(string $threadId): ThreadResponse;

    /**
     * Delete a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/delete-thread
     */
    public function delete(string $threadId): DeleteThreadResponse;

    /**
     * List items in a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/list-thread-items
     *
     * @param  array<string, mixed>  $parameters
     */
    public function listItems(string $threadId, array $parameters = []): ListThreadItemsResponse;
}
