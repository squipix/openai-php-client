<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Content;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * A client tool call (`tool_use`) or an Anthropic-run server tool call (`server_tool_use`).
 *
 * @phpstan-type ToolUseBlockType array{type: 'tool_use'|'server_tool_use', id: string, name: string, input: array<string, mixed>, caller?: ?array<string, mixed>}
 *
 * @implements ResponseContract<ToolUseBlockType>
 */
final class ToolUseBlock implements ResponseContract
{
    /**
     * @use ArrayAccessible<ToolUseBlockType>
     */
    use ArrayAccessible;

    /**
     * @param  'tool_use'|'server_tool_use'  $type
     * @param  array<string, mixed>  $input
     * @param  array<string, mixed>|null  $caller
     */
    private function __construct(
        public readonly string $type,
        public readonly string $id,
        public readonly string $name,
        public readonly array $input,
        public readonly ?array $caller,
    ) {}

    /**
     * @param  ToolUseBlockType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            id: $attributes['id'],
            name: $attributes['name'],
            input: $attributes['input'],
            caller: $attributes['caller'] ?? null,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'id' => $this->id,
            'name' => $this->name,
            'input' => $this->input,
            'caller' => $this->caller,
        ], fn (mixed $value): bool => $value !== null);
    }
}
