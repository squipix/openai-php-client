<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Evals\DeleteEvalResponse;
use OpenAI\Responses\Evals\EvalResponse;
use OpenAI\Responses\Evals\ListEvalsResponse;

interface EvalsContract
{
    /**
     * Create an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/create
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): EvalResponse;

    /**
     * Retrieve an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/retrieve
     */
    public function retrieve(string $id): EvalResponse;

    /**
     * Update an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/update
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(string $id, array $parameters): EvalResponse;

    /**
     * Delete an evaluation.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/delete
     */
    public function delete(string $id): DeleteEvalResponse;

    /**
     * List evaluations.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/list
     *
     * @param  array<string, mixed>  $parameters
     */
    public function list(array $parameters = []): ListEvalsResponse;

    /**
     * Manage evaluation runs.
     *
     * @see https://platform.openai.com/docs/api-reference/evals/runs
     */
    public function runs(): EvalsRunsContract;
}
