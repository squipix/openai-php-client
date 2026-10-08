<?php

namespace OpenAI\Contracts;

use OpenAI\Contracts\Resources\Anthropic\ModelsContract;

interface AnthropicClientContract
{
    /**
     * List and describe the available Claude models.
     *
     * @see https://docs.claude.com/en/api/models-list
     */
    public function models(): ModelsContract;
}
