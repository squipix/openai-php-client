<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\ChatkitContract;
use OpenAI\Resources\Chatkit;
use OpenAI\Testing\Resources\Concerns\Testable;

final class ChatkitTestResource implements ChatkitContract
{
    use Testable;

    protected function resource(): string
    {
        return Chatkit::class;
    }

    public function sessions(): ChatkitSessionsTestResource
    {
        return new ChatkitSessionsTestResource($this->fake);
    }

    public function threads(): ChatkitThreadsTestResource
    {
        return new ChatkitThreadsTestResource($this->fake);
    }
}
