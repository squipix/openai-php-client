<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\ChatkitThreadsContract;
use OpenAI\Responses\Chatkit\Threads\DeleteThreadResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadItemsResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadsResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ChatkitThreadResponseType from ThreadResponse
 * @phpstan-import-type ListChatkitThreadsResponseType from ListThreadsResponse
 * @phpstan-import-type DeleteChatkitThreadResponseType from DeleteThreadResponse
 * @phpstan-import-type ListChatkitThreadItemsResponseType from ListThreadItemsResponse
 */
final class ChatkitThreads implements ChatkitThreadsContract
{
    use Concerns\Transportable;

    /**
     * List Chatkit threads.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/list-threads
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListThreadsResponse
    {
        $payload = Payload::list('chatkit/threads', $parameters);

        /** @var Response<ListChatkitThreadsResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return ListThreadsResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/retrieve-thread
     */
    public function retrieve(string $threadId): ThreadResponse
    {
        $payload = Payload::retrieve('chatkit/threads', $threadId);

        /** @var Response<ChatkitThreadResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return ThreadResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/delete-thread
     */
    public function delete(string $threadId): DeleteThreadResponse
    {
        $payload = Payload::delete('chatkit/threads', $threadId);

        /** @var Response<DeleteChatkitThreadResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return DeleteThreadResponse::from($response->data(), $response->meta());
    }

    /**
     * List items in a Chatkit thread.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/list-thread-items
     *
     * @param  array<string, mixed>  $parameters
     */
    public function listItems(string $threadId, array $parameters = []): ListThreadItemsResponse
    {
        $payload = Payload::retrieve('chatkit/threads', $threadId, '/items', $parameters);

        /** @var Response<ListChatkitThreadItemsResponseType> $response */
        $response = $this->transporter
            ->addHeader('OpenAI-Beta', 'chatkit_beta=v1')
            ->requestObject($payload);

        return ListThreadItemsResponse::from($response->data(), $response->meta());
    }
}
