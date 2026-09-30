<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\FineTuning\Checkpoints\DeletePermissionResponse;
use OpenAI\Responses\FineTuning\Checkpoints\ListPermissionsResponse;

interface FineTuningCheckpointsContract
{
    /**
     * Share fine-tuned models with other projects in the organization.
     *
     * @see https://developers.openai.com/api/reference/resources/fine_tuning/subresources/checkpoints/subresources/permissions/methods/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function createPermission(string $checkpoint, array $parameters): ListPermissionsResponse;

    /**
     * Delete a permission on a fine-tuned model checkpoint.
     *
     * @see https://developers.openai.com/api/reference/resources/fine_tuning/subresources/checkpoints/subresources/permissions/methods/delete
     */
    public function deletePermission(string $checkpoint, string $permission): DeletePermissionResponse;
}
