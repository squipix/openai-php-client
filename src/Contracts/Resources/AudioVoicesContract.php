<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Audio\Voices\CreateResponse;

interface AudioVoicesContract
{
    /**
     * Creates a custom voice.
     *
     * @see https://developers.openai.com/api/reference/resources/audio/subresources/voices/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): CreateResponse;
}
