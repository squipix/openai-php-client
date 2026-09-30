<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\FineTuningCheckpointsContract;
use OpenAI\Responses\FineTuning\Checkpoints\DeletePermissionResponse;
use OpenAI\Responses\FineTuning\Checkpoints\ListPermissionsResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ListPermissionsResponseType from ListPermissionsResponse
 * @phpstan-import-type DeletePermissionResponseType from DeletePermissionResponse
 */
final class FineTuningCheckpoints implements FineTuningCheckpointsContract
{
    use Concerns\Transportable;

    /**
     * Share fine-tuned models with other projects in the organization.
     *
     * @see https://developers.openai.com/api/reference/resources/fine_tuning/subresources/checkpoints/subresources/permissions/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function createPermission(string $checkpoint, array $parameters): ListPermissionsResponse
    {
        $payload = Payload::create("fine_tuning/checkpoints/{$checkpoint}/permissions", $parameters);

        /** @var Response<ListPermissionsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListPermissionsResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete a permission on a fine-tuned model checkpoint.
     *
     * @see https://developers.openai.com/api/reference/resources/fine_tuning/subresources/checkpoints/subresources/permissions/methods/delete
     */
    public function deletePermission(string $checkpoint, string $permission): DeletePermissionResponse
    {
        $payload = Payload::delete("fine_tuning/checkpoints/{$checkpoint}/permissions", $permission);

        /** @var Response<DeletePermissionResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeletePermissionResponse::from($response->data(), $response->meta());
    }
}
