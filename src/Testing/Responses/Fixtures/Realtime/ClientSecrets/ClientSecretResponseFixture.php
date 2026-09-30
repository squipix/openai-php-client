<?php

namespace OpenAI\Testing\Responses\Fixtures\Realtime\ClientSecrets;

final class ClientSecretResponseFixture
{
    public const ATTRIBUTES = [
        'value' => 'ek_1234567890abcdef',
        'expires_at' => 1720000000,
        'session' => [
            'modalities' => ['text', 'audio'],
            'voice' => 'alloy',
        ],
    ];
}
