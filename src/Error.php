<?php

declare(strict_types=1);


namespace Ilex\GraphqlPayloadObject;

final class Error extends \Exception
{
    public static function FileNotFound(string $path): self
    {
        $message = \sprintf('File not found: %s', $path);
        return new self($message);
    }

    public static function FileNotLoad(string $path): self
    {
        $message = \sprintf('Load file fail: %s', $path);
        return new self($message);
    }
}
