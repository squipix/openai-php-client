<?php

use OpenAI\Responses\Anthropic\Models\RetrieveResponse;
use OpenAI\Responses\Meta\MetaInformation;

test('from', function () {
    $response = RetrieveResponse::from(anthropicModel(), meta());

    expect($response)
        ->id->toBe('claude-opus-5-5')
        ->displayName->toBe('Claude Opus 5.5')
        ->meta()->toBeInstanceOf(MetaInformation::class);
});

test('from without optional fields', function () {
    $response = RetrieveResponse::from([
        'type' => 'model',
        'id' => 'claude-haiku-5-5',
        'display_name' => 'Claude Haiku 5.5',
        'created_at' => '2026-09-01T00:00:00Z',
    ], meta());

    expect($response)
        ->maxInputTokens->toBeNull()
        ->maxTokens->toBeNull()
        ->capabilities->toBeNull();
});

test('as array accessible', function () {
    $response = RetrieveResponse::from(anthropicModel(), meta());

    expect($response['display_name'])->toBe('Claude Opus 5.5');
});

test('to array', function () {
    $response = RetrieveResponse::from(anthropicModel(), meta());

    expect($response->toArray())->toBe(anthropicModel());
});

test('fake', function () {
    $response = RetrieveResponse::fake();

    expect($response)->id->toBe('claude-opus-5-5');
});

test('fake with override', function () {
    $response = RetrieveResponse::fake(['id' => 'claude-sonnet-5-5']);

    expect($response)
        ->id->toBe('claude-sonnet-5-5')
        ->displayName->toBe('Claude Opus 5.5');
});
