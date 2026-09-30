<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\EvalsRunsContract;
use OpenAI\Responses\Evals\Runs\DeleteEvalRunResponse;
use OpenAI\Responses\Evals\Runs\EvalRunResponse;
use OpenAI\Responses\Evals\Runs\ListEvalRunsResponse;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\Response;

/**
 * @phpstan-import-type EvalRunResponseType from EvalRunResponse
 * @phpstan-import-type ListEvalRunsResponseType from ListEvalRunsResponse
 * @phpstan-import-type DeleteEvalRunResponseType from DeleteEvalRunResponse
 */
final class EvalsRuns implements EvalsRunsContract
{
    use Concerns\Transportable;

    /**
     * Create an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/create-run
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(string $evalId, array $parameters): EvalRunResponse
    {
        $payload = Payload::create("evals/{$evalId}/runs", $parameters);

        /** @var Response<EvalRunResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalRunResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/retrieve-run
     */
    public function retrieve(string $evalId, string $runId): EvalRunResponse
    {
        $payload = Payload::retrieve("evals/{$evalId}/runs", $runId);

        /** @var Response<EvalRunResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalRunResponse::from($response->data(), $response->meta());
    }

    /**
     * List runs for an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/list-runs
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(string $evalId, array $parameters = []): ListEvalRunsResponse
    {
        $payload = Payload::list("evals/{$evalId}/runs", $parameters);

        /** @var Response<ListEvalRunsResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return ListEvalRunsResponse::from($response->data(), $response->meta());
    }

    /**
     * Cancel an ongoing evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/cancel-run
     */
    public function cancel(string $evalId, string $runId): EvalRunResponse
    {
        $payload = Payload::create("evals/{$evalId}/runs/{$runId}/cancel", []);

        /** @var Response<EvalRunResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return EvalRunResponse::from($response->data(), $response->meta());
    }

    /**
     * Delete an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/delete-run
     */
    public function delete(string $evalId, string $runId): DeleteEvalRunResponse
    {
        $payload = Payload::delete("evals/{$evalId}/runs", $runId);

        /** @var Response<DeleteEvalRunResponseType> $response */
        $response = $this->transporter->requestObject($payload);

        return DeleteEvalRunResponse::from($response->data(), $response->meta());
    }
}
