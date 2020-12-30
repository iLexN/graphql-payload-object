<?php

declare(strict_types=1);

namespace Ilex\GraphqlPayloadObject\Tests;

use Ilex\GraphqlPayloadObject\Error;
use Ilex\GraphqlPayloadObject\Payload;
use PHPUnit\Framework\TestCase;

final class PayloadTest extends TestCase
{

    public function testToJson(): void
    {
        $query = 'query';
        $variables = [
            'a' => 'a',
            'b' => 'b',
        ];
        $payload = Payload::fromString($query, $variables);

        $expected = '{"query":"query","variables":{"a":"a","b":"b"}}';
        self::assertEquals($expected, $payload->toJson());
    }

    public function testToArray(): void
    {
        $query = 'query';
        $variables = [
            'a' => 'a',
            'b' => 'b',
        ];
        $payload = Payload::fromString($query, $variables);

        $expected = [
            'query' => $query,
            'variables' => $variables,
        ];
        self::assertEquals($expected, $payload->toArray());
    }

    public function testWithVariable(): void
    {
        $query = 'query';
        $variables = [
            'a' => 'a',
        ];
        $payload = Payload::fromString($query, $variables);

        $newPayload = $payload->withVariable([
            'a' => 'a',
            'b' => 'b',
        ]);

        $expected = [
            'query' => $query,
            'variables' => $variables,
        ];
        self::assertEquals($expected, $payload->toArray());

        $expected = [
            'query' => $query,
            'variables' => [
                'a' => 'a',
                'b' => 'b',
            ],
        ];
        self::assertEquals($expected, $newPayload->toArray());
    }

    public function testCreateFromPathFileNotExist(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('File not found');
        $path = 'a.gql';
        Payload::fromPath($path);
    }

    public function testCreateFromPathFileNotLoad(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Load file fail');
        $path = __DIR__ .'/test_not_load.gql';
        Payload::fromPath($path);
    }

    public function testCreateFromPathSuccess(): void
    {
        $path = __DIR__ .'/test.gql';
        $payload = Payload::fromPath($path);

        $expected = '{"query":"hello\n","variables":[]}';
        self::assertEquals($expected, $payload->toJson());
    }
}
