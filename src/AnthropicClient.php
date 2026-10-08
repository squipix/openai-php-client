<?php

declare(strict_types=1);

namespace OpenAI;

use OpenAI\Contracts\AnthropicClientContract;
use OpenAI\Contracts\TransporterContract;
use OpenAI\Resources\Anthropic\Files;
use OpenAI\Resources\Anthropic\Messages;
use OpenAI\Resources\Anthropic\Models;
use OpenAI\Resources\Anthropic\Skills;

final class AnthropicClient implements AnthropicClientContract
{
    /**
     * Creates an Anthropic Client instance with the given transporter.
     */
    public function __construct(private readonly TransporterContract $transporter)
    {
        // ..
    }

    /**
     * Create messages with Claude, count tokens, and run message batches.
     *
     * @see https://docs.claude.com/en/api/messages
     */
    public function messages(): Messages
    {
        return new Messages($this->transporter);
    }

    /**
     * Upload and manage files to reference in Messages requests.
     *
     * @see https://docs.claude.com/en/api/files-create
     */
    public function files(): Files
    {
        return new Files($this->transporter);
    }

    /**
     * List and describe the available Claude models.
     *
     * @see https://docs.claude.com/en/api/models-list
     */
    public function models(): Models
    {
        return new Models($this->transporter);
    }

    /**
     * Create and manage custom Agent Skills and their versions.
     *
     * @see https://docs.claude.com/en/api/skills/create-skill
     */
    public function skills(): Skills
    {
        return new Skills($this->transporter);
    }
}
