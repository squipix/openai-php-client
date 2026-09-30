<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\ChatkitSessionsContract;
use OpenAI\Resources\ChatkitSessions;
use OpenAI\Responses\Chatkit\Sessions\SessionResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class ChatkitSessionsTestResource implements ChatkitSessionsContract
{
    use Testable;

    protected function resource(): string
    {
        return ChatkitSessions::class;
    }

    public function create(array $parameters): SessionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function cancel(string $sessionId): SessionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
