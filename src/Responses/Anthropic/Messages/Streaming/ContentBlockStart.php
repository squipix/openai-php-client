<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages\Streaming;

use OpenAI\Actions\Anthropic\ContentBlocks;
use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\Anthropic\Messages\Content\GenericBlock;
use OpenAI\Responses\Anthropic\Messages\Content\RedactedThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;
use OpenAI\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ContentBlockStartType array{type: 'content_block_start', index: int, content_block: array<string, mixed>}
 *
 * @implements ResponseContract<ContentBlockStartType>
 */
final class ContentBlockStart implements ResponseContract
{
    /**
     * @use ArrayAccessible<ContentBlockStartType>
     */
    use ArrayAccessible;

    /**
     * @param  'content_block_start'  $type
     */
    private function __construct(
        public readonly string $type,
        public readonly int $index,
        public readonly TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|GenericBlock $contentBlock,
    ) {}

    /**
     * @param  ContentBlockStartType  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            type: $attributes['type'],
            index: $attributes['index'],
            contentBlock: ContentBlocks::parseOne($attributes['content_block']),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'index' => $this->index,
            'content_block' => $this->contentBlock->toArray(),
        ];
    }
}
