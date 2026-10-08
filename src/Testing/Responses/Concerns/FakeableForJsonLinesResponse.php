<?php

declare(strict_types=1);

namespace OpenAI\Testing\Responses\Concerns;

use Http\Discovery\Psr17FactoryDiscovery;

trait FakeableForJsonLinesResponse
{
    /**
     * Fakes the response from a JSON Lines string, or from the class's `<Name>Fixture.jsonl` file.
     */
    public static function fake(?string $jsonLines = null): static
    {
        if ($jsonLines === null) {
            $filename = str_replace(['OpenAI\Responses', '\\'], [__DIR__.'/../Fixtures/', '/'], static::class).'Fixture.jsonl';
            $jsonLines = (string) file_get_contents($filename);
        }

        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($jsonLines));

        return new static($response);
    }
}
