<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

use OpenAI\Responses\Chatkit\Sessions\SessionResponse;

interface ChatkitSessionsContract
{
    /**
     * Create a Chatkit session.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/create-session
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters): SessionResponse;

    /**
     * Cancel an active Chatkit session.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/cancel-session
     */
    public function cancel(string $sessionId): SessionResponse;
}
