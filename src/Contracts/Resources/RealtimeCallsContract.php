<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Realtime\Calls\CallResponse;

interface RealtimeCallsContract
{
    /**
     * Create a new Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CallResponse;

    /**
     * Accept an incoming Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/accept
     *
     * @param  array<string, mixed>  $parameters
     */
    public function accept(string $callId, array $parameters = []): CallResponse;

    /**
     * Hang up an active Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/hangup
     */
    public function hangup(string $callId): CallResponse;

    /**
     * Refer/transfer an active Realtime API call to another destination.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/refer
     *
     * @param  array<string, mixed>  $parameters
     */
    public function refer(string $callId, array $parameters): CallResponse;

    /**
     * Reject an incoming Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/reject
     */
    public function reject(string $callId): CallResponse;
}
