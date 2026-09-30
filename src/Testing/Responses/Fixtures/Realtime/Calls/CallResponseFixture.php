<?php

namespace OpenAI\Testing\Responses\Fixtures\Realtime\Calls;

final class CallResponseFixture
{
    public const ATTRIBUTES = [
        'id' => 'call_123456',
        'object' => 'realtime.call',
        'status' => 'active',
        'sdp' => 'v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=-\r\nt=0 0\r\n',
    ];
}
