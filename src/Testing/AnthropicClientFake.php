<?php

namespace OpenAI\Testing;

use OpenAI\Contracts\AnthropicClientContract;
use OpenAI\Contracts\ResponseContract;
use OpenAI\Responses\StreamResponse;
use OpenAI\Testing\Resources\Anthropic\FilesTestResource;
use OpenAI\Testing\Resources\Anthropic\MessagesTestResource;
use OpenAI\Testing\Resources\Anthropic\ModelsTestResource;
use OpenAI\Testing\Resources\Anthropic\SkillsTestResource;
use Throwable;

/**
 * Fake Anthropic client. Request recording and assertions are delegated to a {@see ClientFake},
 * so both fakes share the same behaviour.
 */
class AnthropicClientFake implements AnthropicClientContract
{
    private readonly ClientFake $recorder;

    /**
     * @param  array<array-key, ResponseContract|StreamResponse|Throwable|string>  $responses
     */
    public function __construct(array $responses = [])
    {
        $this->recorder = new ClientFake($responses);
    }

    /**
     * @param  array<array-key, ResponseContract|StreamResponse|Throwable|string>  $responses
     */
    public function addResponses(array $responses): void
    {
        $this->recorder->addResponses($responses);
    }

    public function assertSent(string $resource, callable|int|null $callback = null): void
    {
        $this->recorder->assertSent($resource, $callback);
    }

    public function assertNotSent(string $resource, ?callable $callback = null): void
    {
        $this->recorder->assertNotSent($resource, $callback);
    }

    public function assertNothingSent(): void
    {
        $this->recorder->assertNothingSent();
    }

    public function messages(): MessagesTestResource
    {
        return new MessagesTestResource($this->recorder);
    }

    public function files(): FilesTestResource
    {
        return new FilesTestResource($this->recorder);
    }

    public function models(): ModelsTestResource
    {
        return new ModelsTestResource($this->recorder);
    }

    public function skills(): SkillsTestResource
    {
        return new SkillsTestResource($this->recorder);
    }
}
