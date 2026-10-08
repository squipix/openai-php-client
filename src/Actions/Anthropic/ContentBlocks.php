<?php

declare(strict_types=1);

namespace OpenAI\Actions\Anthropic;

use OpenAI\Responses\Anthropic\Messages\Content\GenericBlock;
use OpenAI\Responses\Anthropic\Messages\Content\RedactedThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;

final class ContentBlocks
{
    /**
     * Maps one raw content block to its class. Unknown block types become a {@see GenericBlock}.
     *
     * @param  array<string, mixed>  $block
     */
    public static function parseOne(array $block): TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|GenericBlock
    {
        return match ($block['type'] ?? null) {
            'text' => TextBlock::from($block), // @phpstan-ignore-line
            'thinking' => ThinkingBlock::from($block), // @phpstan-ignore-line
            'redacted_thinking' => RedactedThinkingBlock::from($block), // @phpstan-ignore-line
            'tool_use', 'server_tool_use' => ToolUseBlock::from($block), // @phpstan-ignore-line
            default => GenericBlock::from($block),
        };
    }

    /**
     * @param  array<int, array<string, mixed>>  $blocks
     * @return array<int, TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|GenericBlock>
     */
    public static function parse(array $blocks): array
    {
        return array_map(self::parseOne(...), $blocks);
    }
}
