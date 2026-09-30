<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\EvalsContract;
use OpenAI\Responses\Evals\DeleteEvalResponse;
use OpenAI\Responses\Evals\EvalResponse;
use OpenAI\Responses\Evals\ListEvalsResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type EvalResponseType from EvalResponse
 * @phpstan-import-type ListEvalsResponseType from ListEvalsResponse
 * @phpstan-import-type DeleteEvalResponseType from DeleteEvalResponse
 */
final class Evals implements EvalsContract
{
    use Concerns\Transportable;

    /**
     * Create an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): EvalResponse
    {
        $payload = Payload::create('evals', $parameters);

        /** @var Response<EvalResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/retrieve
     */
    public function retrieve(string $id): EvalResponse
    {
        $payload = Payload::retrieve('evals', $id);

        /** @var Response<EvalResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalResponse::from($response->data(), $response->meta());
    }

    /**
     * Update an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/update
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(string $id, array $parameters): EvalResponse
    {
        $payload = Payload::modify('evals', $id, $parameters);

        /** @var Response<EvalResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/delete
     */
    public function delete(string $id): DeleteEvalResponse
    {
        $payload = Payload::delete('evals', $id);

        /** @var Response<DeleteEvalResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteEvalResponse::from($response->data(), $response->meta());
    }

    /**
     * List evaluations.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListEvalsResponse
    {
        $payload = Payload::list('evals', $parameters);

        /** @var Response<ListEvalsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListEvalsResponse::from($response->data(), $response->meta());
    }

    /**
     * Manage evaluation runs.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/runs
     */
    public function runs(): EvalsRuns
    {
        return new EvalsRuns($this->transporter);
    }
}
