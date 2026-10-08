<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\MessagesBatchesContract;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type BatchResponseType from BatchResponse
 * @phpstan-import-type ListResponseType from ListResponse
 * @phpstan-import-type DeleteResponseType from DeleteResponse
 */
final class MessagesBatches implements MessagesBatchesContract
{
    use Transportable;

    /**
     * Creates a batch of Messages requests, processed asynchronously at a discount.
     *
     * @see https://docs.claude.com/en/api/creating-message-batches
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): BatchResponse
    {
        $payload = Payload::create('messages/batches', $parameters);

        /** @var Response<BatchResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return BatchResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a batch. Poll until `processingStatus` is `ended`.
     *
     * @see https://docs.claude.com/en/api/retrieving-message-batches
     */
    public function retrieve(string $id): BatchResponse
    {
        $payload = Payload::retrieve('messages/batches', $id);

        /** @var Response<BatchResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return BatchResponse::from($response->data(), $response->meta());
    }

    /**
     * Lists batches, most recently created first.
     *
     * @see https://docs.claude.com/en/api/listing-message-batches
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('messages/batches', $parameters);

        /** @var Response<ListResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Cancels a batch that is still processing.
     *
     * @see https://docs.claude.com/en/api/canceling-message-batches
     */
    public function cancel(string $id): BatchResponse
    {
        $payload = Payload::cancel('messages/batches', $id);

        /** @var Response<BatchResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return BatchResponse::from($response->data(), $response->meta());
    }

    /**
     * Deletes a batch that has finished processing.
     *
     * @see https://docs.claude.com/en/api/deleting-message-batches
     */
    public function delete(string $id): DeleteResponse
    {
        $payload = Payload::delete('messages/batches', $id);

        /** @var Response<DeleteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteResponse::from($response->data(), $response->meta());
    }

    /**
     * Streams the results of an ended batch, one result per line.
     *
     * @see https://docs.claude.com/en/api/retrieving-message-batch-results
     */
    public function results(string $id): BatchResultsResponse
    {
        $payload = Payload::retrieve('messages/batches', $id, '/results');

        return new BatchResultsResponse($this->transporter->requestStream($payload));
    }
}
