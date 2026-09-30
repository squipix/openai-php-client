<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Evals\Runs\DeleteEvalRunResponse;
use OpenAI\Responses\Evals\Runs\EvalRunResponse;
use OpenAI\Responses\Evals\Runs\ListEvalRunsResponse;

interface EvalsRunsContract
{
    /**
     * Create an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/create-run
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(string $evalId, array $parameters): EvalRunResponse;

    /**
     * Retrieve an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/retrieve-run
     */
    public function retrieve(string $evalId, string $runId): EvalRunResponse;

    /**
     * List runs for an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/list-runs
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(string $evalId, array $parameters = []): ListEvalRunsResponse;

    /**
     * Cancel an ongoing evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/cancel-run
     */
    public function cancel(string $evalId, string $runId): EvalRunResponse;

    /**
     * Delete an evaluation run.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/delete-run
     */
    public function delete(string $evalId, string $runId): DeleteEvalRunResponse;
}
