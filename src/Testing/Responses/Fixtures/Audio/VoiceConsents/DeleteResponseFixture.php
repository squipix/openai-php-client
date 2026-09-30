<?php

namespace OpenAI\Testing\Responses\Fixtures\Audio\VoiceConsents;

final class DeleteResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'cons_1234',
        'object' => 'audio.voice_consent',
        'deleted' => true,
    ];
}
