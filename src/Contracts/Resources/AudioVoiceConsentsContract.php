<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Audio\VoiceConsents\DeleteResponse;
use OpenAI\Responses\Audio\VoiceConsents\ListResponse;
use OpenAI\Responses\Audio\VoiceConsents\VoiceConsentResponse;

interface AudioVoiceConsentsContract
{
    /**
     * Upload a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): VoiceConsentResponse;

    /**
     * List voice consent records.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse;

    /**
     * Retrieve a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/retrieve
     */
    public function retrieve(string $id): VoiceConsentResponse;

    /**
     * Update a voice consent recording label.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/update
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(string $id, array $parameters): VoiceConsentResponse;

    /**
     * Delete a voice consent recording.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voice_consents/methods/delete
     */
    public function delete(string $id): DeleteResponse;
}
