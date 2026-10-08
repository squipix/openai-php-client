<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\MessagesBatchesContract;
use OpenAI\Resources\Anthropic\MessagesBatches;
use OpenAI\Responses\Anthropic\Batches\BatchResponse;
use OpenAI\Responses\Anthropic\Batches\BatchResultsResponse;
use OpenAI\Responses\Anthropic\Batches\DeleteResponse;
use OpenAI\Responses\Anthropic\Batches\ListResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class MessagesBatchesTestResource implements MessagesBatchesContract
{
    use Testable;

    protected function resource(): string
    {
        return MessagesBatches::class;
    }

    public function create(array $parameters): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $id): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function cancel(string $id): BatchResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $id): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function results(string $id): BatchResultsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
