<?php
declare(strict_types=1);

namespace Ilex\GraphqlPayloadObject;

function file_get_contents(string $path): mixed
{
    $fileName = basename($path);

    if ($fileName === 'test.gql'){
        return \file_get_contents($path);
    }

    return false;
}
