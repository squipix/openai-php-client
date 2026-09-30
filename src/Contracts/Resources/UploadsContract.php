<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Uploads\UploadPartResponse;
use OpenAI\Responses\Uploads\UploadResponse;

interface UploadsContract
{
    /**
     * Creates an intermediate Upload object that you can add Parts to.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): UploadResponse;

    /**
     * Adds a Part to an Upload object. A Part represents a chunk of bytes from the file you are trying to upload.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/subresources/parts/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function uploadPart(string $uploadId, array $parameters): UploadPartResponse;

    /**
     * Completes the Upload.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/complete
     *
     * @param  array<string, mixed>  $parameters
     */
    public function complete(string $uploadId, array $parameters): UploadResponse;

    /**
     * Cancels the Upload. No Parts may be added after an Upload is cancelled.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/cancel
     */
    public function cancel(string $uploadId): UploadResponse;
}
