<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages;

use OpenAI\Actions\Anthropic\ContentBlocks;
use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Anthropic\Messages\Content\GenericBlock;
use OpenAI\Responses\Anthropic\Messages\Content\RedactedThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\TextBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ThinkingBlock;
use OpenAI\Responses\Anthropic\Messages\Content\ToolUseBlock;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type UsageType from Usage
 *
 * @phpstan-type CreateResponseType array{id: string, type: 'message', role: 'assistant', model: string, content: array<int, array<string, mixed>>, stop_reason: ?string, stop_sequence: ?string, stop_details?: ?array<string, mixed>, usage: UsageType, container?: ?array<string, mixed>}
 *
 * @implements ResponseContract<CreateResponseType>
 */
final class CreateResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<CreateResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'message'  $type
     * @param  'assistant'  $role
     * @param  array<int, TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|GenericBlock>  $content
     * @param  array<string, mixed>|null  $stopDetails
     * @param  array<string, mixed>|null  $container
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $role,
        public readonly string $model,
        public readonly array $content,
        public readonly ?string $stopReason,
        public readonly ?string $stopSequence,
        public readonly ?array $stopDetails,
        public readonly Usage $usage,
        public readonly ?array $container,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  CreateResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            type: $attributes['type'],
            role: $attributes['role'],
            model: $attributes['model'],
            content: ContentBlocks::parse($attributes['content']),
            stopReason: $attributes['stop_reason'],
            stopSequence: $attributes['stop_sequence'],
            stopDetails: $attributes['stop_details'] ?? null,
            usage: Usage::from($attributes['usage']),
            container: $attributes['container'] ?? null,
            meta: $meta,
        );
    }

    /**
     * Concatenated text of all `text` blocks.
     */
    public function text(): string
    {
        return implode('', array_map(
            fn (TextBlock $block): string => $block->text,
            array_filter($this->content, fn (object $block): bool => $block instanceof TextBlock),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'role' => $this->role,
            'model' => $this->model,
            'content' => array_map(fn (TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|GenericBlock $block): array => $block->toArray(), $this->content),
            'stop_reason' => $this->stopReason,
            'stop_sequence' => $this->stopSequence,
        ];

        if ($this->stopDetails !== null) {
            $data['stop_details'] = $this->stopDetails;
        }

        $data['usage'] = $this->usage->toArray();

        if ($this->container !== null) {
            $data['container'] = $this->container;
        }

        return $data;
    }
}
