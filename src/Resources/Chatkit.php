<?php

declare(strict_types=1);

namespace OpenAI\Resources;

use OpenAI\Contracts\Resources\ChatkitContract;

final class Chatkit implements ChatkitContract
{
    use Concerns\Transportable;

    /**
     * Manage Chatkit sessions.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/sessions
     */
    public function sessions(): ChatkitSessions
    {
        return new ChatkitSessions($this->transporter);
    }

    /**
     * Manage Chatkit threads.
     *
     * @see https://platform.openai.com/docs/api-reference/chatkit/threads
     */
    public function threads(): ChatkitThreads
    {
        return new ChatkitThreads($this->transporter);
    }
}
