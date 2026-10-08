<?php

declare(strict_types=1);

namespace OpenAI;

use OpenAI\Contracts\AnthropicClientContract;
use OpenAI\Contracts\TransporterContract;
use OpenAI\Resources\Anthropic\Models;

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
     * List and describe the available Claude models.
     *
     * @see https://docs.claude.com/en/api/models-list
     */
    public function models(): Models
    {
        return new Models($this->transporter);
    }
}
