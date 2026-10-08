<?php

use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;

test('from', function () {
    $response = ListResponse::from(anthropicModelList(), meta());

    expect($response)
        ->data->toHaveCount(2)
        ->data->each->toBeInstanceOf(RetrieveResponse::class)
        ->hasMore->toBeFalse()
        ->lastId->toBe('claude-opus-5-5');
});

test('as array accessible', function () {
    $response = ListResponse::from(anthropicModelList(), meta());

    expect($response['has_more'])->toBeFalse();
});

test('to array', function () {
    $response = ListResponse::from(anthropicModelList(), meta());

    expect($response->toArray())->toBe(anthropicModelList());
});

test('fake', function () {
    $response = ListResponse::fake();

    expect($response->data[0])->id->toBe('claude-opus-5-5');
});

test('fake with override', function () {
    $response = ListResponse::fake(['data' => [['id' => 'claude-haiku-5-5']]]);

    expect($response->data[0])
        ->id->toBe('claude-haiku-5-5')
        ->displayName->toBe('Claude Opus 5.5');
});
