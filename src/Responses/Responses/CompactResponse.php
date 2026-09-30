<?php

declare(strict_types=1);

namespace OpenAI\Responses\Responses;

use OpenAI\Actions\Responses\OutputObjects;
use OpenAI\Contracts\ResponseContract;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Responses\Concerns\ArrayAccessible;
use OpenAI\Responses\Concerns\HasMetaInformation;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Responses\Responses\Output\OutputApplyPatchToolCall;
use OpenAI\Responses\Responses\Output\OutputCodeInterpreterToolCall;
use OpenAI\Responses\Responses\Output\OutputCompaction;
use OpenAI\Responses\Responses\Output\OutputComputerToolCall;
use OpenAI\Responses\Responses\Output\OutputCustomToolCall;
use OpenAI\Responses\Responses\Output\OutputFileSearchToolCall;
use OpenAI\Responses\Responses\Output\OutputFunctionToolCall;
use OpenAI\Responses\Responses\Output\OutputImageGenerationToolCall;
use OpenAI\Responses\Responses\Output\OutputLocalShellCall;
use OpenAI\Responses\Responses\Output\OutputMcpApprovalRequest;
use OpenAI\Responses\Responses\Output\OutputMcpCall;
use OpenAI\Responses\Responses\Output\OutputMcpListTools;
use OpenAI\Responses\Responses\Output\OutputMessage;
use OpenAI\Responses\Responses\Output\OutputProgram;
use OpenAI\Responses\Responses\Output\OutputProgramOutput;
use OpenAI\Responses\Responses\Output\OutputReasoning;
use OpenAI\Responses\Responses\Output\OutputToolSearchCall;
use OpenAI\Responses\Responses\Output\OutputToolSearchOutput;
use OpenAI\Responses\Responses\Output\OutputWebSearchToolCall;
use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type ResponseOutputObjectTypes from OutputObjects
 * @phpstan-import-type ResponseOutputObjectReturnType from OutputObjects
 * @phpstan-import-type UsageType from CreateResponseUsage
 *
 * @phpstan-type CompactResponseType array{id: string, object: 'response.compaction', created_at: int, output: ResponseOutputObjectTypes, usage?: UsageType|null}
 *
 * @implements ResponseContract<CompactResponseType>
 */
final class CompactResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<CompactResponseType>
     */
    use ArrayAccessible;

    use Fakeable;
    use HasMetaInformation;

    /**
     * @param  'response.compaction'  $object
     * @param  ResponseOutputObjectReturnType  $output
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $createdAt,
        public readonly array $output,
        public readonly ?CreateResponseUsage $usage,
        private readonly MetaInformation $meta,
    ) {}

    /**
     * @param  CompactResponseType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            id: $attributes['id'],
            object: $attributes['object'],
            createdAt: $attributes['created_at'],
            output: OutputObjects::parse($attributes['output']),
            usage: isset($attributes['usage']) ? CreateResponseUsage::from($attributes['usage']) : null,
            meta: $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'created_at' => $this->createdAt,
            'output' => array_map(
                fn (OutputApplyPatchToolCall|OutputMessage|OutputComputerToolCall|OutputFileSearchToolCall|OutputWebSearchToolCall|OutputFunctionToolCall|OutputProgram|OutputProgramOutput|OutputReasoning|OutputMcpListTools|OutputMcpApprovalRequest|OutputMcpCall|OutputImageGenerationToolCall|OutputCodeInterpreterToolCall|OutputLocalShellCall|OutputCustomToolCall|OutputToolSearchCall|OutputToolSearchOutput|OutputCompaction $output): array => $output->toArray(),
                $this->output
            ),
            'usage' => $this->usage?->toArray(),
        ];
    }
}
