<?php

use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;
use OpenAI\ValueObjects\Transporter\Response;

test('upload', function () {
    $client = anthropicMockClient('POST', 'files', [], Response::from(anthropicFile(), anthropicMetaHeaders()), validateParams: false);

    $result = $client->files()->upload(['file' => fileResourceResource()]);

    expect($result)
        ->toBeInstanceOf(FileResponse::class)
        ->id->toBe('file_011CNha8iCJcU1wXNR6q4V8w')
        ->mimeType->toBe('application/pdf')
        ->sizeBytes->toBe(1024000)
        ->and($result->meta()->requestId)->toBe('req_011CSHoEeqs5C35K2UUqR7Fy');
});

test('list', function () {
    $client = anthropicMockClient('GET', 'files', ['limit' => 1], Response::from([
        'data' => [anthropicFile()],
        'has_more' => false,
        'first_id' => 'file_011CNha8iCJcU1wXNR6q4V8w',
        'last_id' => 'file_011CNha8iCJcU1wXNR6q4V8w',
    ], anthropicMetaHeaders()));

    $result = $client->files()->list(['limit' => 1]);

    expect($result)
        ->toBeInstanceOf(ListResponse::class)
        ->data->toHaveCount(1)
        ->data->each->toBeInstanceOf(FileResponse::class);
});

test('retrieve', function () {
    $client = anthropicMockClient('GET', 'files/file_011CNha8iCJcU1wXNR6q4V8w', [], Response::from(anthropicFile(), anthropicMetaHeaders()));

    expect($client->files()->retrieve('file_011CNha8iCJcU1wXNR6q4V8w'))
        ->filename->toBe('report.pdf')
        ->downloadable->toBeTrue();
});

test('download', function () {
    $client = anthropicMockContentClient('GET', 'files/file_011CNha8iCJcU1wXNR6q4V8w/content', [], '%PDF-1.7');

    expect($client->files()->download('file_011CNha8iCJcU1wXNR6q4V8w'))->toBe('%PDF-1.7');
});

test('delete', function () {
    $client = anthropicMockClient('DELETE', 'files/file_011CNha8iCJcU1wXNR6q4V8w', [], Response::from(['id' => 'file_011CNha8iCJcU1wXNR6q4V8w', 'type' => 'file_deleted'], anthropicMetaHeaders()));

    expect($client->files()->delete('file_011CNha8iCJcU1wXNR6q4V8w'))
        ->toBeInstanceOf(DeleteResponse::class)
        ->type->toBe('file_deleted');
});
