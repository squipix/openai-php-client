<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\AudioVoiceConsentsContract;
use OpenAI\Resources\AudioVoiceConsents;
use OpenAI\Responses\Audio\VoiceConsents\DeleteResponse;
use OpenAI\Responses\Audio\VoiceConsents\ListResponse;
use OpenAI\Responses\Audio\VoiceConsents\VoiceConsentResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class AudioVoiceConsentsTestResource implements AudioVoiceConsentsContract
{
    use Testable;

    protected function resource(): string
    {
        return AudioVoiceConsents::class;
    }

    public function create(array $parameters): VoiceConsentResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $id): VoiceConsentResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function update(string $id, array $parameters): VoiceConsentResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $id): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
