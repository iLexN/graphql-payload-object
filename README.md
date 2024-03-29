# graphql-payload-object
> Simple Object to build graphql payload, and use your favourite http client to send.

[![Latest Stable Version](https://poser.pugx.org/ilexn/graphql-payload-object/v/stable)](https://packagist.org/packages/ilexn/graphql-payload-object)
[![Total Downloads](https://poser.pugx.org/ilexn/graphql-payload-object/downloads)](https://packagist.org/packages/ilexn/graphql-payload-object)

![GitHub Action](https://github.com/iLexN/graphql-payload-object/workflows/CI%20Check/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/iLexN/graphql-payload-object/badge.svg?branch=main)](https://coveralls.io/github/iLexN/graphql-payload-object?branch=main)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FiLexN%2Fgraphql-payload-object%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/iLexN/graphql-payload-object/main)

## Installation
```sh
composer require ilexn/graphql-payload-object
```

## Usage example
```php
<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$query = <<<'QUERY'
query HeroNameAndFriends($episode: Episode) {
  hero(episode: $episode) {
    name
    friends {
      name
    }
  }
}
QUERY;

$variables = [
    "episode" => "JEDI",
];


$payload = \Ilex\GraphqlPayloadObject\Payload::fromString($query, $variables);
// or from path
//$payload = \Ilex\GraphqlPayloadObject\Payload::fromPath('example.gql', $variables);


// use the same query , with different variable set
$newPayload = $payload->withVariable([
    'episode' => 'new episode',
    'key' => 'new value',
]);

// Symfony HttpClient Component
$client = Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('POST',
    'http://example.com/graphql', [
        'body' => $payload->toJson(),
        // or
        //'json' => $payload->toArray(),
    ]);
var_dump($response->toArray());

// Guzzle, PHP HTTP client
$client = new GuzzleHttp\Client();
$response = $client->post('http://example.com/graphql', [
    'body' => $payload->toJson(),
    // or
    //'json' => $payload->toArray(),
]);
var_dump((string)$response->getBody());
```
