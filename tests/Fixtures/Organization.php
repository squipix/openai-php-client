<?php

/**
 * @return array<string, mixed>
 */
function auditLogResource(): array
{
    return [
        'id' => 'audit_log_123456',
        'type' => 'api_key.created',
        'effective_at' => 1720000000,
        'actor' => [
            'type' => 'user',
            'user' => ['id' => 'user_123', 'email' => 'admin@example.com'],
        ],
        'api_key' => [
            'id' => 'key_123',
            'type' => 'user',
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function auditLogListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            auditLogResource(),
        ],
        'first_id' => 'audit_log_123456',
        'last_id' => 'audit_log_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function inviteResource(): array
{
    return [
        'id' => 'invite_123456',
        'object' => 'organization.invite',
        'email' => 'developer@example.com',
        'role' => 'member',
        'status' => 'pending',
        'invited_at' => 1720000000,
        'expires_at' => 1722592000,
        'accepted_at' => null,
        'projects' => [
            ['id' => 'proj_123', 'role' => 'member'],
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function inviteListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            inviteResource(),
        ],
        'first_id' => 'invite_123456',
        'last_id' => 'invite_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function inviteDeleteResource(): array
{
    return [
        'id' => 'invite_123456',
        'object' => 'organization.invite.deleted',
        'deleted' => true,
    ];
}

/**
 * @return array<string, mixed>
 */
function userResource(): array
{
    return [
        'id' => 'user_123456',
        'object' => 'organization.user',
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'role' => 'member',
        'added_at' => 1720000000,
    ];
}

/**
 * @return array<string, mixed>
 */
function userListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            userResource(),
        ],
        'first_id' => 'user_123456',
        'last_id' => 'user_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function userDeleteResource(): array
{
    return [
        'id' => 'user_123456',
        'object' => 'organization.user.deleted',
        'deleted' => true,
    ];
}

/**
 * @return array<string, mixed>
 */
function projectResource(): array
{
    return [
        'id' => 'proj_123456',
        'object' => 'organization.project',
        'name' => 'Production API',
        'created_at' => 1720000000,
        'archived_at' => null,
        'status' => 'active',
    ];
}

/**
 * @return array<string, mixed>
 */
function projectListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            projectResource(),
        ],
        'first_id' => 'proj_123456',
        'last_id' => 'proj_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function adminApiKeyResource(): array
{
    return [
        'id' => 'key_123456',
        'object' => 'organization.admin_api_key',
        'name' => 'CI Deployment Key',
        'redacted_value' => 'sk-admin-...abcd',
        'value' => 'sk-admin-1234567890abcdef',
        'created_at' => 1720000000,
        'owner' => [
            'type' => 'user',
            'user' => ['id' => 'user_123', 'email' => 'admin@example.com'],
        ],
    ];
}

/**
 * @return array<string, mixed>
 */
function adminApiKeyListResource(): array
{
    return [
        'object' => 'list',
        'data' => [
            adminApiKeyResource(),
        ],
        'first_id' => 'key_123456',
        'last_id' => 'key_123456',
        'has_more' => false,
    ];
}

/**
 * @return array<string, mixed>
 */
function adminApiKeyDeleteResource(): array
{
    return [
        'id' => 'key_123456',
        'object' => 'organization.admin_api_key.deleted',
        'deleted' => true,
    ];
}
