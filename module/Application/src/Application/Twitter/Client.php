<?php
/**
 * File contains class Client
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter;

use Zend\Http\Client as HttpClient;
use Zend\Http\Headers;
use Zend\Http\Response as HttpResponse;
use Zend\Http\Request as HttpRequest;
use Zend\Stdlib\Parameters;

/**
 * Class Client
 *
 * @package Application\Twitter
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * @var string
     */
    protected $version = '1.1';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Client constructor.
     *
     * @param HttpClient $httpClient
     * @param string     $apiEndpoint
     */
    public function __construct(HttpClient $httpClient, $apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->httpClient  = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * {@inheritdoc}
     */
    public function get($endpoint, array $params = [], array $headers = [], $versioned = true)
    {
        $request = $this->assembleRequest('GET', $params, $headers);
        $request->setUri($this->assembleEndpoint($endpoint, $versioned));

        return $this->assembleResponse($this->httpClient->send($request));
    }

    /**
     * {@inheritdoc}
     */
    public function post($endpoint, array $params = [], array $headers = [], $versioned = true)
    {
        $request = $this->assembleRequest('POST', $params, $headers);
        $request->setUri($this->assembleEndpoint($endpoint, $versioned));

        return $this->assembleResponse($this->httpClient->send($request));
    }


    /**
     * @param string $endpoint
     * @param bool   $versioned
     *
     * @return string
     */
    public function assembleEndpoint($endpoint, $versioned = true)
    {
        $versionedPattern = '%s/%s/%s';
        $unversionedPattern = '%s/%s';

        if (true === $versioned) {
            return sprintf(
                $versionedPattern,
                rtrim($this->apiEndpoint, '/'),
                $this->version,
                ltrim($endpoint, '/')
            );
        }

        return sprintf(
            $unversionedPattern,
            rtrim($this->apiEndpoint, '/'),
            ltrim($endpoint, '/')
        );
    }

    protected function assembleRequest($method, array $params, array $headers)
    {
        $request = new HttpRequest();
        $request->setMethod($method);

        $headersObject = new Headers();
        $headersObject->addHeaders($headers);
        $request->setHeaders($headersObject);

        $params = new Parameters($params);
        switch ($method) {
            case 'POST' :
                $request->setContent(http_build_query($params->toArray()));
                break;
            default:
                $request->setQuery($params);
                break;
        }

        return $request;
    }

    /**
     * @param HttpResponse $httpResponse
     *
     * @return Response
     */
    protected function assembleResponse(HttpResponse $httpResponse)
    {
        $response = new Response();
        $response->setStatusCode($httpResponse->getStatusCode());
        $response->setBody($httpResponse->getBody());

        return $response;
    }
}