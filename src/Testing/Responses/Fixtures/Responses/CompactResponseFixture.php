<?php

namespace OpenAI\Testing\Responses\Fixtures\Responses;

final class CompactResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'resp_compact_67ccf18ef5fc8190b16dbee19bc54e5f087bb177ab789d5c',
        'object' => 'response.compaction',
        'created_at' => 1741484430,
        'output' => [
            [
                'id' => 'cmp_67ccf18f64008190a39b619f4c8455ef087bb177ab789d5c',
                'encrypted_content' => 'encrypted_string_value',
                'type' => 'compaction',
                'created_by' => 'user_123',
            ],
        ],
        'usage' => [
            'input_tokens' => 139,
            'input_tokens_details' => [
                'cached_tokens' => 0,
            ],
            'output_tokens' => 438,
            'output_tokens_details' => [
                'reasoning_tokens' => 64,
            ],
            'total_tokens' => 577,
        ],
    ];
}
