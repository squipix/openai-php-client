<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\UploadsContract;
use OpenAI\Responses\Uploads\UploadPartResponse;
use OpenAI\Responses\Uploads\UploadResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type UploadResponseType from UploadResponse
 * @phpstan-import-type UploadPartResponseType from UploadPartResponse
 */
final class Uploads implements UploadsContract
{
    use Concerns\Transportable;

    /**
     * Creates an intermediate Upload object that you can add Parts to.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): UploadResponse
    {
        $payload = Payload::create('uploads', $parameters);

        /** @var Response<UploadResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UploadResponse::from($response->data(), $response->meta());
    }

    /**
     * Adds a Part to an Upload object. A Part represents a chunk of bytes from the file you are trying to upload.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/subresources/parts/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function uploadPart(string $uploadId, array $parameters): UploadPartResponse
    {
        $payload = Payload::upload('uploads/'.rawurlencode($uploadId).'/parts', $parameters);

        /** @var Response<UploadPartResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UploadPartResponse::from($response->data(), $response->meta());
    }

    /**
     * Completes the Upload.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/complete
     *
     * @param  array<string, mixed>  $parameters
     */
    public function complete(string $uploadId, array $parameters): UploadResponse
    {
        $payload = Payload::create('uploads/'.rawurlencode($uploadId).'/complete', $parameters);

        /** @var Response<UploadResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UploadResponse::from($response->data(), $response->meta());
    }

    /**
     * Cancels the Upload. No Parts may be added after an Upload is cancelled.
     *
     * @see https://developers.openai.com/api/reference/resources/uploads/methods/cancel
     */
    public function cancel(string $uploadId): UploadResponse
    {
        $payload = Payload::cancel('uploads', $uploadId);

        /** @var Response<UploadResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return UploadResponse::from($response->data(), $response->meta());
    }
}
