<?php

declare(strict_types=1);

namespace OpenAI\Responses\Anthropic\Batches;

use Generator;
use OpenAI\Contracts\ResponseHasMetaInformationContract;
use OpenAI\Contracts\ResponseStreamContract;
use OpenAI\Responses\Meta\MetaInformation;
use OpenAI\Testing\Responses\Concerns\FakeableForJsonLinesResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Iterates a batch results file (JSON Lines) one result at a time, without loading the whole file.
 * Results are in no particular order: match them by `customId`.
 *
 * @phpstan-import-type BatchResultType from BatchResult
 *
 * @implements ResponseStreamContract<BatchResult>
 */
final class BatchResultsResponse implements ResponseHasMetaInformationContract, ResponseStreamContract
{
    use FakeableForJsonLinesResponse;

    public function __construct(private readonly ResponseInterface $response) {}

    /**
     * @return Generator<int, BatchResult>
     */
    public function getIterator(): Generator
    {
        $body = $this->response->getBody();
        $meta = $this->meta();
        $buffer = '';

        while (! $body->eof() || $buffer !== '') {
            if (! $body->eof()) {
                $buffer .= $body->read(65536);
            }

            $lines = explode("\n", $buffer);
            $buffer = $body->eof() ? '' : (string) array_pop($lines);

            foreach ($lines as $line) {
                $line = trim($line);

                if ($line === '') {
                    continue;
                }

                /** @var BatchResultType $attributes */
                $attributes = json_decode($line, true, flags: JSON_THROW_ON_ERROR);

                yield BatchResult::from($attributes, $meta);
            }
        }
    }

    public function meta(): MetaInformation
    {
        return MetaInformation::from(MetaInformation::headersFrom($this->response));
    }
}
