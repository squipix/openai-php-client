<?php

use OpenAI\Responses\Anthropic\Messages\CountTokensResponse;

test('from', function () {
    $response = CountTokensResponse::from(['input_tokens' => 14], meta());

    expect($response)->inputTokens->toBe(14)
        ->and($response['input_tokens'])->toBe(14)
        ->and($response->toArray())->toBe(['input_tokens' => 14]);
});

test('fake', function () {
    expect(CountTokensResponse::fake(['input_tokens' => 7]))->inputTokens->toBe(7);
});
