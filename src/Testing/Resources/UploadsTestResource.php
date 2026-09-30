<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\UploadsContract;
use OpenAI\Resources\Uploads;
use OpenAI\Responses\Uploads\UploadPartResponse;
use OpenAI\Responses\Uploads\UploadResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class UploadsTestResource implements UploadsContract
{
    use Testable;

    protected function resource(): string
    {
        return Uploads::class;
    }

    public function create(array $parameters): UploadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function uploadPart(string $uploadId, array $parameters): UploadPartResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function complete(string $uploadId, array $parameters): UploadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function cancel(string $uploadId): UploadResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
