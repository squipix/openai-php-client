<?php

namespace OpenAI\Contracts\Resources\Anthropic;

use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;

interface ModelsContract
{
    /**
     * Lists the available models, most recently released first.
     *
     * @see https://docs.claude.com/en/api/models-list
     *
     * @param  array<string, mixed>  $parameters  e.g. `limit`, `after_id`, `before_id`
     */
    public function list(array $parameters = []): ListResponse;

    /**
     * Retrieves a model by its ID or alias.
     *
     * @see https://docs.claude.com/en/api/models
     */
    public function retrieve(string $model): RetrieveResponse;
}
