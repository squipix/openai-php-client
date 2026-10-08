<?php

use OpenAI\ValueObjects\ResourceUri;

it('encodes ids so they cannot alter the path or query', function () {
    expect(ResourceUri::retrieve('files', '../x?y#z', '')->toString())->toBe('files/..%2Fx%3Fy%23z')
        ->and(ResourceUri::delete('files', 'file-abc_123')->toString())->toBe('files/file-abc_123')
        ->and(ResourceUri::delete('models', 'ft:gpt-4o:org:abc')->toString())->toBe('models/ft:gpt-4o:org:abc');
});
