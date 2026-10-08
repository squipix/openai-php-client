<?php

use OpenAI\AnthropicClient;
use OpenAI\Client;
use OpenAI\Contracts\TransporterContract;
use OpenAI\ValueObjects\ApiKey;
use OpenAI\ValueObjects\Transporter\AdaptableResponse;
use OpenAI\ValueObjects\Transporter\BaseUri;
use OpenAI\ValueObjects\Transporter\Headers;
use OpenAI\ValueObjects\Transporter\Payload;
use OpenAI\ValueObjects\Transporter\QueryParams;
use OpenAI\ValueObjects\Transporter\Response;
use Psr\Http\Message\ResponseInterface;

function mockClient(string $method, string $resource, array $params, Response|AdaptableResponse|ResponseInterface|string $response, $methodName = 'requestObject', bool $validateParams = true)
{
    return new Client(mockTransporter($method, $resource, $params, $response, $methodName, $validateParams));
}

function anthropicMockClient(string $method, string $resource, array $params, Response|ResponseInterface|string $response, $methodName = 'requestObject', bool $validateParams = true)
{
    return new AnthropicClient(mockTransporter($method, $resource, $params, $response, $methodName, $validateParams));
}

function anthropicMockContentClient(string $method, string $resource, array $params, string $response, bool $validateParams = true)
{
    return anthropicMockClient($method, $resource, $params, $response, 'requestContent', $validateParams);
}

function anthropicMockStreamClient(string $method, string $resource, array $params, ResponseInterface $response, bool $validateParams = true)
{
    return anthropicMockClient($method, $resource, $params, $response, 'requestStream', $validateParams);
}

function mockTransporter(string $method, string $resource, array $params, Response|AdaptableResponse|ResponseInterface|string $response, $methodName = 'requestObject', bool $validateParams = true): TransporterContract
{
    $transporter = Mockery::mock(TransporterContract::class);

    $transporter
        ->shouldReceive('addHeader')
        ->zeroOrMoreTimes()
        ->andReturnSelf();

    $transporter
        ->shouldReceive($methodName)
        ->once()
        ->withArgs(function (Payload $payload) use ($validateParams, $method, $resource, $params) {
            $baseUri = BaseUri::from('api.openai.com/v1');
            $headers = Headers::withAuthorization(ApiKey::from('foo'));
            $queryParams = QueryParams::create();

            $request = $payload->toRequest($baseUri, $headers, $queryParams);

            if ($validateParams) {
                if (in_array($method, ['GET', 'DELETE'])) {
                    if ($request->getUri()->getQuery() !== http_build_query($params)) {
                        return false;
                    }
                } else {
                    if ($request->getBody()->getContents() !== json_encode($params)) {
                        return false;
                    }
                }
            }

            return $request->getMethod() === $method
                && $request->getUri()->getPath() === "/v1/$resource";
        })->andReturn($response);

    return $transporter;
}

function mockContentClient(string $method, string $resource, array $params, string $response, bool $validateParams = true)
{
    return mockClient($method, $resource, $params, $response, 'requestContent', $validateParams);
}

function mockStreamClient(string $method, string $resource, array $params, ResponseInterface $response, bool $validateParams = true)
{
    return mockClient($method, $resource, $params, $response, 'requestStream', $validateParams);
}
