<?php

declare(strict_types=1);

namespace OpenAI\Contracts\Resources;

interface ChatkitContract
{
    /**
     * Manage Chatkit sessions.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/sessions
     */
    public function sessions(): ChatkitSessionsContract;

    /**
     * Manage Chatkit threads.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/threads
     */
    public function threads(): ChatkitThreadsContract;
}
