<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\RealtimeCallsContract;
use OpenAI\Responses\Realtime\Calls\CallResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type CallResponseType from CallResponse
 */
final class RealtimeCalls implements RealtimeCallsContract
{
    use Concerns\Transportable;

    /**
     * Create a new Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CallResponse
    {
        $payload = Payload::create('realtime/calls', $parameters);

        /** @var Response<CallResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CallResponse::from($response->data(), $response->meta());
    }

    /**
     * Accept an incoming Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/accept
     *
     * @param  array<string, mixed>  $parameters
     */
    public function accept(string $callId, array $parameters = []): CallResponse
    {
        $payload = Payload::create('realtime/calls/'.rawurlencode($callId).'/accept', $parameters);

        /** @var Response<CallResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CallResponse::from($response->data(), $response->meta());
    }

    /**
     * Hang up an active Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/hangup
     */
    public function hangup(string $callId): CallResponse
    {
        $payload = Payload::create('realtime/calls/'.rawurlencode($callId).'/hangup', []);

        /** @var Response<CallResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CallResponse::from($response->data(), $response->meta());
    }

    /**
     * Refer/transfer an active Realtime API call to another destination.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/refer
     *
     * @param  array<string, mixed>  $parameters
     */
    public function refer(string $callId, array $parameters): CallResponse
    {
        $payload = Payload::create('realtime/calls/'.rawurlencode($callId).'/refer', $parameters);

        /** @var Response<CallResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CallResponse::from($response->data(), $response->meta());
    }

    /**
     * Reject an incoming Realtime API call.
     *
     * @see https://platform.openai.com/docs/api-reference/realtime-calls/reject
     */
    public function reject(string $callId): CallResponse
    {
        $payload = Payload::create('realtime/calls/'.rawurlencode($callId).'/reject', []);

        /** @var Response<CallResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CallResponse::from($response->data(), $response->meta());
    }
}
