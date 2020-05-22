<?php

declare(strict_types=1);

namespace Ilex\GraphqlPayloadObject;

final class Payload
{
    private string $query;

    /**
     * @var array<string,mixed>
     */
    private array $variables;

    /**
     * Payload constructor.
     *
     * @param string $query
     * @param array<string,mixed> $variables
     */
    private function __construct(string $query, array $variables = [])
    {
        $this->query = $query;
        $this->variables = $variables;
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
     * @param string $key
     * @param mixed $value
     */
    public function addVariable(string $key, $value): void
    {
        $this->variables[$key] = $value;
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
     * @param string $path
     * @param array<string,mixed> $variables
     *
     * @return self
     * @throws \Ilex\GraphqlPayloadObject\Error
     */
    public static function fromPath(string $path, $variables = []): self
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
     * @param string $query
     * @param array<string,mixed> $variables
     *
     * @return self
     */
    public static function fromString(string $query, $variables = []): self
    {
        return new self($query, $variables);
    }
}
