<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\FineTuningCheckpointsContract;
use OpenAI\Resources\FineTuningCheckpoints;
use OpenAI\Responses\FineTuning\Checkpoints\DeletePermissionResponse;
use OpenAI\Responses\FineTuning\Checkpoints\ListPermissionsResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class FineTuningCheckpointsTestResource implements FineTuningCheckpointsContract
{
    use Testable;

    protected function resource(): string
    {
        return FineTuningCheckpoints::class;
    }

    public function createPermission(string $checkpoint, array $parameters): ListPermissionsResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function deletePermission(string $checkpoint, string $permission): DeletePermissionResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
