<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\FilesContract;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Files\DeleteResponse;
use OpenAI\Responses\Anthropic\Files\FileResponse;
use OpenAI\Responses\Anthropic\Files\ListResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type FileResponseType from FileResponse
 * @phpstan-import-type ListResponseType from ListResponse
 * @phpstan-import-type DeleteResponseType from DeleteResponse
 */
final class Files implements FilesContract
{
    use Transportable;

    /**
     * Uploads a file to reference in Messages requests.
     *
     * @see https://docs.claude.com/en/api/files-create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function upload(array $parameters): FileResponse
    {
        $payload = Payload::upload('files', $parameters);

        /** @var Response<FileResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return FileResponse::from($response->data(), $response->meta());
    }

    /**
     * Lists the uploaded files, most recently created first.
     *
     * @see https://docs.claude.com/en/api/files-list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('files', $parameters);

        /** @var Response<ListResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a file's metadata.
     *
     * @see https://docs.claude.com/en/api/files-metadata
     */
    public function retrieve(string $id): FileResponse
    {
        $payload = Payload::retrieve('files', $id);

        /** @var Response<FileResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return FileResponse::from($response->data(), $response->meta());
    }

    /**
     * Downloads a file's content.
     *
     * @see https://docs.claude.com/en/api/files-content
     */
    public function download(string $id): string
    {
        $payload = Payload::retrieveContent('files', $id);

        return $this->transporter->requestContent($payload);
    }

    /**
     * Deletes a file.
     *
     * @see https://docs.claude.com/en/api/files-delete
     */
    public function delete(string $id): DeleteResponse
    {
        $payload = Payload::delete('files', $id);

        /** @var Response<DeleteResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteResponse::from($response->data(), $response->meta());
    }
}
