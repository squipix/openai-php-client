<?php

/**
 * @return array<string, mixed>
 */
function realtimeClientSecretResource(): array
{
    return [
        'value' => 'ek_1234567890abcdef',
        'expires_at' => 1720000000,
        'session' => [
            'modalities' => ['text', 'audio'],
            'voice' => 'alloy',
        ],
    ];
}
