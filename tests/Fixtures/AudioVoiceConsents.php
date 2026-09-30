<?php

/**
 * @return array<string, mixed>
 */
function voiceConsentResource(): array
{
    return [
        'id' => 'cons_1234',
        'created_at' => 1719184911,
        'language' => 'en-US',
        'name' => 'John Doe',
        'object' => 'audio.voice_consent',
    ];
}

/**
 * @return array<string, mixed>
 */
function voiceConsentListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            voiceConsentResource(),
        ],
        'first_id' => 'cons_1234',
        'last_id' => 'cons_1234',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function voiceConsentDeleteResource(): array
{
    return [
        'id' => 'cons_1234',
        'object' => 'audio.voice_consent',
        'deleted' => true,
    ];
}
