<?php

namespace OpenAI\Testing\Responses\Fixtures\Chatkit\Sessions;

final class SessionResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'chatkit_sess_123456',
        'object' => 'chatkit.session',
        'client_secret' => 'ck_sec_1234567890abcdef',
        'expires_at' => 1720000000,
        'chatkit_configuration' => [
            'automatic_thread_titling' => true,
        ],
    ];
}
