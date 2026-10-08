<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;

interface MessagesBatchesContract
{
    /**
     * Creates a batch of Messages requests, processed asynchronously at a discount.
     *
     * @see https://docs.claude.com/en/api/creating-message-batches
     *
     * @param  array<string, mixed>  $parameters  `['requests' => [['custom_id' => ..., 'params' => [...]], ...]]`
     */
    public function create(array $parameters): BatchResponse;

    /**
     * Retrieves a batch. Poll until `processingStatus` is `ended`.
     *
     * @see https://docs.claude.com/en/api/retrieving-message-batches
     */
    public function retrieve(string $id): BatchResponse;

    /**
     * Lists batches, most recently created first.
     *
     * @see https://docs.claude.com/en/api/listing-message-batches
     *
     * @param  array<string, mixed>  $parameters  e.g. `limit`, `after_id`, `before_id`
     */
    public function list(array $parameters = []): ListResponse;

    /**
     * Cancels a batch that is still processing.
     *
     * @see https://docs.claude.com/en/api/canceling-message-batches
     */
    public function cancel(string $id): BatchResponse;

    /**
     * Deletes a batch that has finished processing.
     *
     * @see https://docs.claude.com/en/api/deleting-message-batches
     */
    public function delete(string $id): DeleteResponse;

    /**
     * Streams the results of an ended batch, one result per line.
     *
     * @see https://docs.claude.com/en/api/retrieving-message-batch-results
     */
    public function results(string $id): BatchResultsResponse;
}
