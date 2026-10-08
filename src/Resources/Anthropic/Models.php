<?php

declare(strict_types=1);

namespace OpenAI\Resources\Anthropic;

use OpenAI\Contracts\Resources\Anthropic\ModelsContract;
use OpenAI\Resources\Concerns\Transportable;
use OpenAI\Responses\Anthropic\Models\ListResponse;
use OpenAI\Responses\Anthropic\Models\RetrieveResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type ListResponseType from ListResponse
 * @phpstan-import-type RetrieveResponseType from RetrieveResponse
 */
final class Models implements ModelsContract
{
    use Transportable;

    /**
     * Lists the available models, most recently released first.
     *
     * @see https://docs.claude.com/en/api/models-list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('models', $parameters);

        /** @var Response<ListResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieves a model by its ID or alias.
     *
     * @see https://docs.claude.com/en/api/models
     */
    public function retrieve(string $model): RetrieveResponse
    {
        $payload = Payload::retrieve('models', $model);

        /** @var Response<RetrieveResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return RetrieveResponse::from($response->data(), $response->meta());
    }
}
