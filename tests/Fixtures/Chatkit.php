<?php

/**
 * @return array<string, mixed>
 */
function chatkitSessionResource(): array
{
    return [
        'id' => 'chatkit_sess_123456',
        'object' => 'chatkit.session',
        'client_secret' => 'ck_sec_1234567890abcdef',
        'expires_at' => 1720000000,
        'chatkit_configuration' => [
            'automatic_thread_titling' => true,
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function chatkitThreadResource(): array
{
    return [
        'id' => 'chatkit_th_123456',
        'object' => 'chatkit.thread',
        'created_at' => 1720000000,
        'title' => 'General Inquiries',
        'user' => 'user_123456',
        'status' => 'active',
    ];
}

/**
 * @return array<string, mixed>
 */
function chatkitThreadListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            chatkitThreadResource(),
        ],
        'first_id' => 'chatkit_th_123456',
        'last_id' => 'chatkit_th_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function chatkitThreadDeleteResource(): array
{
    return [
        'id' => 'chatkit_th_123456',
        'object' => 'chatkit.thread.deleted',
        'deleted' => true,
    ];
}

/**
 * @return array<string, mixed>
 */
function chatkitThreadItemResource(): array
{
    return [
        'id' => 'item_123456',
        'object' => 'chatkit.thread_user_message_item',
        'created_at' => 1720000000,
        'type' => 'user_message',
        'content' => 'Hello, I need help with my account.',
    ];
}

/**
 * @return array<string, mixed>
 */
function chatkitThreadItemListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            chatkitThreadItemResource(),
        ],
        'first_id' => 'item_123456',
        'last_id' => 'item_123456',
        'has_more' => false,
    ];
}
