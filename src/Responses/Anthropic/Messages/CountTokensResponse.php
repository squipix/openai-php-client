<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Messages;

use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-type CountTokensResponseType array{input_tokens: int}
 *
 * @implements ResponseContract<CountTokensResponseType>
 */
final class CountTokensResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<CountTokensResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    private function __construct(
        public readonly int $inputTokens,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  CountTokensResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self($attributes['input_tokens'], $meta);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['input_tokens' => $this->inputTokens];
    }
}
