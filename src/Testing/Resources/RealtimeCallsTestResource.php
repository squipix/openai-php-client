<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\RealtimeCallsContract;
use OpenAI\Resources\RealtimeCalls;
use OpenAI\Responses\Realtime\Calls\CallResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class RealtimeCallsTestResource implements RealtimeCallsContract
{
    use Testable;

    protected function resource(): string
    {
        return RealtimeCalls::class;
    }

    public function create(array $parameters): CallResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function accept(string $callId, array $parameters = []): CallResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function hangup(string $callId): CallResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function refer(string $callId, array $parameters): CallResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function reject(string $callId): CallResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
