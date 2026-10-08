<?php

use OpenAI\Resources\Anthropic\Files;
use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;
use OpenAI\Testing\AnthropicClientFake;

it('records file requests', function () {
    $fake = new AnthropicClientFake([
        FileResponse::fake(),
        ListResponse::fake(),
        FileResponse::fake(),
        'file contents',
        DeleteResponse::fake(),
    ]);

    $fake->files()->upload(['file' => 'resource']);
    $fake->files()->list();
    $fake->files()->retrieve('file_1');
    $content = $fake->files()->download('file_1');
    $fake->files()->delete('file_1');

    expect($content)->toBe('file contents');

    $fake->assertSent(Files::class, 5);
    $fake->assertSent(Files::class, fn (string $method, mixed $argument = null): bool => $method === 'download' && $argument === 'file_1');
});
