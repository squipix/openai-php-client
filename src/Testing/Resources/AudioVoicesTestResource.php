<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\AudioVoicesContract;
use OpenAI\Resources\AudioVoices;
use OpenAI\Responses\Audio\Voices\CreateResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class AudioVoicesTestResource implements AudioVoicesContract
{
    use Testable;

    protected function resource(): string
    {
        return AudioVoices::class;
    }

    public function create(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
