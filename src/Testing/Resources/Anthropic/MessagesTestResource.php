<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\MessagesContract;
use OpenAI\Resources\Anthropic\Messages;
use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;
use OpenAI\Responses\Anthropic\Messages\CreateResponse;
use OpenAI\Responses\StreamResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class MessagesTestResource implements MessagesContract
{
    use Testable;

    protected function resource(): string
    {
        return Messages::class;
    }

    public function batches(): MessagesBatchesTestResource
    {
        return new MessagesBatchesTestResource($this->fake);
    }

    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function createStreamed(array $parameters): StreamResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function countTokens(array $parameters): CountTokensResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
