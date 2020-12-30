<?php
declare(strict_types=1);

namespace Ilex\GraphqlPayloadObject;

/**
 * @param string $path
 *
 * @return string|false
 */
function file_get_contents(string $path): string|false
{
    $fileName = basename($path);

    if ($fileName === 'test.gql') {
        return \file_get_contents($path);
    }

    return false;
}
