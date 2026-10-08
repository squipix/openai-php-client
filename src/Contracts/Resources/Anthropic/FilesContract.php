<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;

interface FilesContract
{
    /**
     * Uploads a file to reference in Messages requests (`['type' => 'file', 'file_id' => ...]`).
     *
     * @see https://docs.claude.com/en/api/files-create
     *
     * @param  array<string, mixed>  $parameters  `['file' => fopen(...)]`
     */
    public function upload(array $parameters): FileResponse;

    /**
     * Lists the uploaded files, most recently created first.
     *
     * @see https://docs.claude.com/en/api/files-list
     *
     * @param  array<string, mixed>  $parameters  e.g. `limit`, `after_id`, `before_id`
     */
    public function list(array $parameters = []): ListResponse;

    /**
     * Retrieves a file's metadata.
     *
     * @see https://docs.claude.com/en/api/files-metadata
     */
    public function retrieve(string $id): FileResponse;

    /**
     * Downloads a file's content. Only files created by skills or the code execution tool are downloadable.
     *
     * @see https://docs.claude.com/en/api/files-content
     */
    public function download(string $id): string;

    /**
     * Deletes a file.
     *
     * @see https://docs.claude.com/en/api/files-delete
     */
    public function delete(string $id): DeleteResponse;
}
