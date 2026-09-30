<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\ChatkitThreadsContract;
use OpenAI\Resources\ChatkitThreads;
use OpenAI\Responses\Chatkit\Threads\DeleteThreadResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadItemsResponse;
use OpenAI\Responses\Chatkit\Threads\ListThreadsResponse;
use OpenAI\Responses\Chatkit\Threads\ThreadResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class ChatkitThreadsTestResource implements ChatkitThreadsContract
{
    use Testable;

    protected function resource(): string
    {
        return ChatkitThreads::class;
    }

    public function list(array $parameters = []): ListThreadsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $threadId): ThreadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $threadId): DeleteThreadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function listItems(string $threadId, array $parameters = []): ListThreadItemsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
