<?php

use OpenAI\Responses\Audio\Voices\CreateResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $client = mockClient('POST', 'audio/voices', [
        'name' => 'My new voice',
        'consent' => 'cons_1234',
        'audio_sample' => fileResourceResource(),
    ], Response::from(voiceResource(), metaHeaders()), validateParams: false);

    $result = $client->audio()->voices()->create([
        'name' => 'My new voice',
        'consent' => 'cons_1234',
        'audio_sample' => fileResourceResource(),
    ]);

    expect($result)
        ->toBeInstanceOf(CreateResponse::class)
        ->id->toBe('voice_1234')
        ->object->toBe('audio.voice')
        ->createdAt->toBe(1719184911)
        ->name->toBe('My new voice');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
