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

$payload->addVariable('key', 'value');


// use the same query , with different variable set
$newPayload = $payload->withVariable([
    'episode' => 'new episode',
    'key' => 'new value',
]);

// Symfony HttpClient Component
$client = Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('POST',
    'http://drupal.docker.localhost:8000/graphql/', [
        'body' => $payload->toJson(),
        // or
        //'json' => $p->toArray(),
    ]);
var_dump($response->toArray());

// Guzzle, PHP HTTP client
$client = new GuzzleHttp\Client();
$response = $client->post('http://drupal.docker.localhost:8000/graphql/', [
    'body' => $payload->toJson(),
    // or
    //'json' => $p->toArray(),
]);
var_dump((string)$response->getBody());


