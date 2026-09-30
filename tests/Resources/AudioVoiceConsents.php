<?php

use OpenAI\Responses\Audio\VoiceConsents\DeleteResponse;
use OpenAI\Responses\Audio\VoiceConsents\ListResponse;
use OpenAI\Responses\Audio\VoiceConsents\VoiceConsentResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('create', function () {
    $client = mockClient('POST', 'audio/voice_consents', [
        'name' => 'John Doe',
        'language' => 'en-US',
        'recording' => fileResourceResource(),
    ], Response::from(voiceConsentResource(), metaHeaders()), validateParams: false);

    $result = $client->audio()->voiceConsents()->create([
        'name' => 'John Doe',
        'language' => 'en-US',
        'recording' => fileResourceResource(),
    ]);

    expect($result)
        ->toBeInstanceOf(VoiceConsentResponse::class)
        ->id->toBe('cons_1234')
        ->object->toBe('audio.voice_consent')
        ->createdAt->toBe(1719184911)
        ->language->toBe('en-US')
        ->name->toBe('John Doe');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('list', function () {
    $client = mockClient('GET', 'audio/voice_consents', [], Response::from(voiceConsentListResource(), metaHeaders()));

    $result = $client->audio()->voiceConsents()->list();

    expect($result)
        ->toBeInstanceOf(ListResponse::class)
        ->object->toBe('list')
        ->data->toBeArray()->toHaveCount(1)
        ->data->each->toBeInstanceOf(VoiceConsentResponse::class);

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('retrieve', function () {
    $client = mockClient('GET', 'audio/voice_consents/cons_1234', [], Response::from(voiceConsentResource(), metaHeaders()));

    $result = $client->audio()->voiceConsents()->retrieve('cons_1234');

    expect($result)
        ->toBeInstanceOf(VoiceConsentResponse::class)
        ->id->toBe('cons_1234')
        ->object->toBe('audio.voice_consent');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('update', function () {
    $client = mockClient('POST', 'audio/voice_consents/cons_1234', [
        'name' => 'John Doe Updated',
    ], Response::from(array_merge(voiceConsentResource(), ['name' => 'John Doe Updated']), metaHeaders()));

    $result = $client->audio()->voiceConsents()->update('cons_1234', [
        'name' => 'John Doe Updated',
    ]);

    expect($result)
        ->toBeInstanceOf(VoiceConsentResponse::class)
        ->id->toBe('cons_1234')
        ->name->toBe('John Doe Updated');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});

test('delete', function () {
    $client = mockClient('DELETE', 'audio/voice_consents/cons_1234', [], Response::from(voiceConsentDeleteResource(), metaHeaders()));

    $result = $client->audio()->voiceConsents()->delete('cons_1234');

    expect($result)
        ->toBeInstanceOf(DeleteResponse::class)
        ->id->toBe('cons_1234')
        ->object->toBe('audio.voice_consent')
        ->deleted->toBeTrue();

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class);
});
