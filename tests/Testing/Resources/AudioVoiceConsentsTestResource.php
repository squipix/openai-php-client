<?php

use OpenAI\Resources\AudioVoiceConsents;
use OpenAI\Responses\Audio\VoiceConsents\DeleteResponse;
use OpenAI\Responses\Audio\VoiceConsents\ListResponse;
use OpenAI\Responses\Audio\VoiceConsents\VoiceConsentResponse;
use OpenAI\Testing\ClientFake;

it('records a voice consent create request', function () {
    $fake = new ClientFake([
        VoiceConsentResponse::fake(),
    ]);

    $fake->audio()->voiceConsents()->create([
        'name' => 'John Doe',
        'language' => 'en-US',
    ]);

    $fake->assertSent(AudioVoiceConsents::class, function ($method, $parameters) {
        return $method === 'create' &&
            $parameters['name'] === 'John Doe';
    });
});

it('records a voice consent list request', function () {
    $fake = new ClientFake([
        ListResponse::fake(),
    ]);

    $fake->audio()->voiceConsents()->list();

    $fake->assertSent(AudioVoiceConsents::class, function ($method) {
        return $method === 'list';
    });
});

it('records a voice consent retrieve request', function () {
    $fake = new ClientFake([
        VoiceConsentResponse::fake(),
    ]);

    $fake->audio()->voiceConsents()->retrieve('cons_1234');

    $fake->assertSent(AudioVoiceConsents::class, function ($method, $id) {
        return $method === 'retrieve' &&
            $id === 'cons_1234';
    });
});

it('records a voice consent update request', function () {
    $fake = new ClientFake([
        VoiceConsentResponse::fake(),
    ]);

    $fake->audio()->voiceConsents()->update('cons_1234', [
        'name' => 'Jane Doe',
    ]);

    $fake->assertSent(AudioVoiceConsents::class, function ($method, $id, $parameters) {
        return $method === 'update' &&
            $id === 'cons_1234' &&
            $parameters['name'] === 'Jane Doe';
    });
});

it('records a voice consent delete request', function () {
    $fake = new ClientFake([
        DeleteResponse::fake(),
    ]);

    $fake->audio()->voiceConsents()->delete('cons_1234');

    $fake->assertSent(AudioVoiceConsents::class, function ($method, $id) {
        return $method === 'delete' &&
            $id === 'cons_1234';
    });
});
