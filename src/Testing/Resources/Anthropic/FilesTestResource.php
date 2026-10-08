<?php

namespace OpenAI\Testing\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\FilesContract;
use OpenAI\Resources\Anthropic\Files;
use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class FilesTestResource implements FilesContract
{
    use Testable;

    protected function resource(): string
    {
        return Files::class;
    }

    public function upload(array $parameters): FileResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function list(array $parameters = []): ListResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function retrieve(string $id): FileResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function download(string $id): string
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function delete(string $id): DeleteResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
