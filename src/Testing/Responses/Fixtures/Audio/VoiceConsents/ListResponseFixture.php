<?php

namespace OpenAI\Testing\Responses\Fixtures\Audio\VoiceConsents;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            VoiceConsentResponseFixture::ATTRIBUTES,
        ],
        'first_id' => 'cons_1234',
        'last_id' => 'cons_1234',
        'has_more' => false,
    ];
}
