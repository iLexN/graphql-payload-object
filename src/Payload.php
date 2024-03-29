<?php

declare(strict_types=1);

namespace Ilex\GraphqlPayloadObject;

final class Payload
{

    /**
     * Payload constructor.
     *
     * @param array<string,mixed> $variables
     */
    private function __construct(
        private readonly string $query,
        private readonly array $variables = []
    )
    {
    }

    /**
     * @return string
     * @throws \JsonException
     */
    public function toJson(): string
    {
        return \json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'query' => $this->query,
            'variables' => $this->variables,
        ];
    }

    /**
     * @param array<string,mixed> $variables
     *
     * @return self
     */
    public function withVariable(array $variables): self
    {
        return new self($this->query, $variables);
    }

    /**
     * @param array<string,mixed> $variables
     *
     * @return self
     * @throws \Ilex\GraphqlPayloadObject\Error
     */
    public static function fromPath(string $path, array $variables = []): self
    {
        if (!\file_exists($path)) {
            throw Error::FileNotFound($path);
        }

        //check file path;
        $query = file_get_contents($path);
        if ($query === false) {
            throw Error::FileNotLoad($path);
        }

        return new self($query, $variables);
    }

    /**
     * @param array<string,mixed> $variables
     * @return self
     */
    public static function fromString(string $query, array $variables = []): self
    {
        return new self($query, $variables);
    }
}
