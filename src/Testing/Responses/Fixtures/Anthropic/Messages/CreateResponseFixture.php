<?php

namespace OpenAI\Testing\Responses\Fixtures\Anthropic\Messages;

final class CreateResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'msg_01XFDUDYJgAACzvnptvVoYEL',
        'type' => 'message',
        'role' => 'assistant',
        'model' => 'claude-opus-5-5',
        'content' => [
            [
                'type' => 'text',
                'text' => 'Hello! How can I help you today?',
            ],
        ],
        'stop_reason' => 'end_turn',
        'stop_sequence' => null,
        'usage' => [
            'input_tokens' => 12,
            'output_tokens' => 10,
            'cache_creation_input_tokens' => 0,
            'cache_read_input_tokens' => 0,
        ],
    ];
}
