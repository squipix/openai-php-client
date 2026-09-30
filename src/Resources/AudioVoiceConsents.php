<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\AudioVoiceConsentsContract;
use OpenAI\Responses\Audio\VoiceConsents\DeleteResponse;
use OpenAI\Responses\Audio\VoiceConsents\ListResponse;
use OpenAI\Responses\Audio\VoiceConsents\VoiceConsentResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type VoiceConsentResponseType from VoiceConsentResponse
 * @phpstan-import-type ListResponseType from ListResponse
 * @phpstan-import-type DeleteResponseType from DeleteResponse
 */
final class AudioVoiceConsents implements AudioVoiceConsentsContract
{
    use Concerns\Transportable;

    /**
     * Upload a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): VoiceConsentResponse
    {
        $payload = Payload::upload('audio/voice_consents', $parameters);

        /** @var Response<VoiceConsentResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return VoiceConsentResponse::from($response->data(), $response->meta());
    }

    /**
     * List voice consent records.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('audio/voice_consents', $parameters);

        /** @var Response<ListResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/retrieve
     */
    public function retrieve(string $id): VoiceConsentResponse
    {
        $payload = Payload::retrieve('audio/voice_consents', $id);

        /** @var Response<VoiceConsentResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return VoiceConsentResponse::from($response->data(), $response->meta());
    }

    /**
     * Update a voice consent recording label.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/update
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(string $id, array $parameters): VoiceConsentResponse
    {
        $payload = Payload::modify('audio/voice_consents', $id, $parameters);

        /** @var Response<VoiceConsentResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return VoiceConsentResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/delete
     */
    public function delete(string $id): DeleteResponse
    {
        $payload = Payload::delete('audio/voice_consents', $id);

        /** @var Response<DeleteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteResponse::from($response->data(), $response->meta());
    }
}
