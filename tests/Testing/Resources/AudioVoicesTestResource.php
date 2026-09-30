<?php

use OpenAI\Resources\AudioVoices;
use OpenAI\Responses\Audio\Voices\CreateResponse;
use OpenAI\Testing\ClientFake;

it('records a voice create request', function () {
    $fake = new ClientFake([
        CreateResponse::fake(),
    ]);

    $fake->audio()->voices()->create([
        'name' => 'My new voice',
        'consent' => 'cons_1234',
    ]);

    $fake->assertSent(AudioVoices::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['name'] === 'My new voice';
    });
});
