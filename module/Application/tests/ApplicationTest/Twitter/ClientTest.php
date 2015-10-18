<?php
/**
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace ApplicationTest\Twitter;


use Application\Twitter\Client;
use Application\Twitter\Response;
use Mockery;
use Zend\Http\Client as HttpClient;
use Zend\Http\Headers;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Stdlib\Parameters;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function AssembleEndpoint_WhenEndpointStringProvided_ShouldAssembleFullEndpointWithHostAndVersion()
    {
        $endpoint = '/test';
        $host     = 'https://api.twitter.com/';
        $version  = '1.1';

        $expected = 'https://api.twitter.com/1.1/test';

        $client = new Client(Mockery::mock(HttpClient::class), $host);
        $client->setVersion($version);

        $this->assertEquals($expected, $client->assembleEndpoint($endpoint));
    }

    /**
     * @test
     */
    public function Get_WhenRequestPerformed_ShouldReturnResponseObject()
    {
        $testEndpoint = '/search';
        $params       = ['geocode' => '123,123,32'];

        $client = $this->clientFactory(
            $testEndpoint,
            true,
            $this->requestFactory('GET', $params),
            $this->responseFactory(200, '{"test": "test"}')
        );

        $response = $client->get($testEndpoint, $params, [], true);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertObjectHasAttribute('test', $response->getBody());
        $this->assertEquals('test', $response->getBody()->test);
    }

    /**
     * @test
     */
    public function Post_WhenRequestPerformed_ShouldReturnResponseObject()
    {
        $testEndpoint = '/oauth2/token';
        $params       = ['grant_type' => 'client_credentials'];

        $client = $this->clientFactory(
            $testEndpoint,
            false,
            $this->requestFactory('POST', $params),
            $this->responseFactory(200, '{"access_token": "someAccessToken"}')
        );

        $response = $client->post($testEndpoint, $params, [], false);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->isSuccess());
        $this->assertObjectHasAttribute('access_token', $response->getBody());
        $this->assertEquals('someAccessToken', $response->getBody()->access_token);
    }

    /**
     * @param string       $endpoint
     * @param bool         $versioned
     * @param HttpRequest  $request
     * @param HttpResponse $response
     *
     * @return Client
     */
    private function clientFactory($endpoint, $versioned, HttpRequest $request, HttpResponse $response)
    {
        $httpClient = Mockery::mock(HttpClient::class);
        $client     = new Client($httpClient, 'https://api.twitter.com');

        $request->setUri($client->assembleEndpoint($endpoint, $versioned));

        $httpClient->shouldReceive('send')->with(
            Mockery::on(
                function (HttpRequest $actualRequest) use ($request) {
                    return $actualRequest == $request;
                }
            )
        )->once()->andReturn($response);

        return $client;
    }

    /**
     * @param string $method
     * @param array  $params
     * @param array  $headers
     *
     * @return HttpRequest
     */
    private function requestFactory($method, array $params = [], array $headers = [])
    {
        $request = new HttpRequest();
        $request->setMethod($method);

        $headersObject = new Headers();
        $headersObject->addHeaders($headers);
        $request->setHeaders($headersObject);

        $params = new Parameters($params);
        switch ($method) {
            case 'GET':
                $request->setQuery($params);
                break;
            case 'POST':
                $request->setContent(http_build_query($params->toArray()));
                break;
        }

        return $request;
    }

    /**
     * @param int    $statusCode
     * @param string $rawBody
     *
     * @return HttpResponse
     */
    private function responseFactory($statusCode, $rawBody)
    {
        $response = new HttpResponse();
        $response->setStatusCode($statusCode)->setContent($rawBody);

        return $response;
    }
}
