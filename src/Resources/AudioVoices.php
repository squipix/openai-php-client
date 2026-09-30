<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\AudioVoicesContract;
use OpenAI\Responses\Audio\Voices\CreateResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type CreateVoiceResponseType from CreateResponse
 */
final class AudioVoices implements AudioVoicesContract
{
    use Concerns\Transportable;

    /**
     * Creates a custom voice.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voices/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CreateResponse
    {
        $payload = Payload::upload('audio/voices', $parameters);

        /** @var Response<CreateVoiceResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return CreateResponse::from($response->data(), $response->meta());
    }
}
