<?php

namespace OpenAI\Contracts;

use OpenAI\Contracts\Resources\Anthropic\MessagesContract;
use OpenAI\Contracts\Resources\Anthropic\ModelsContract;

interface AnthropicClientContract
{
    /**
     * Create messages with Claude, count tokens, and run message batches.
     *
     * @see https://docs.claude.com/en/api/messages
     */
    public function messages(): MessagesContract;

    /**
     * List and describe the available Claude models.
     *
     * @see https://docs.claude.com/en/api/models-list
     */
    public function models(): ModelsContract;
}
