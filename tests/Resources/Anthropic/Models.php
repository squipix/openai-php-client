<?php

use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\ValueObjects\Transporter\Response;

test('list', function () {
    $client = anthropicMockClient('GET', 'models', ['limit' => 2], Response::from(anthropicModelList(), anthropicMetaHeaders()));

    $result = $client->models()->list(['limit' => 2]);

    expect($result)
        ->toBeInstanceOf(ListResponse::class)
        ->data->toHaveCount(2)
        ->data->each->toBeInstanceOf(RetrieveResponse::class)
        ->hasMore->toBeFalse()
        ->firstId->toBe('claude-opus-5-5');

    expect($result->meta())
        ->toBeInstanceOf(MetaInformation::class)
        ->requestId->toBe('req_011CSHoEeqs5C35K2UUqR7Fy');
});

test('retrieve', function () {
    $client = anthropicMockClient('GET', 'models/claude-opus-5-5', [], Response::from(anthropicModel(), anthropicMetaHeaders()));

    $result = $client->models()->retrieve('claude-opus-5-5');

    expect($result)
        ->toBeInstanceOf(RetrieveResponse::class)
        ->type->toBe('model')
        ->id->toBe('claude-opus-5-5')
        ->displayName->toBe('Claude Opus 5.5')
        ->createdAt->toBe('2026-09-01T00:00:00Z')
        ->maxInputTokens->toBe(1000000)
        ->maxTokens->toBe(128000)
        ->capabilities->toBe(['thinking' => ['supported' => true]]);

    expect($result->meta()->custom->toArray())
        ->toHaveKey('anthropic-ratelimit-requests-remaining');
});
