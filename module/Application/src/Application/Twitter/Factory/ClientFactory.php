<?php
/**
 * File contains class ClientFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Factory;

use Application\Twitter\Client;
use Interop\Container\ContainerInterface;
use RuntimeException;
use Zend\Http\Client as HttpClient;

/**
 * Class ClientFactory
 *
 * @package Application\Twitter\Factory
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class ClientFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $baseConfig = $container->get('Config');
        $config     = isset($baseConfig['twitter']) && is_array($baseConfig['twitter']) ? $baseConfig['twitter'] : [];

        if (empty($config['api_endpoint'])) {
            throw new RuntimeException(
                'Twitter API endpoint must be defined under twitter.api_endpoint config'
            );
        }

        $endpoint = $config['api_endpoint'];
        $version  = isset($config['api_version']) ? $config['api_version'] : null;

        $httpConfig = [];
        if (isset($baseConfig['http_client_defaults']) && is_array($baseConfig['http_client_defaults'])) {
            $httpConfig = $baseConfig['http_client_defaults'];
        }

        $httpClient = new HttpClient(null, $httpConfig);
        $client     = new Client($httpClient, $endpoint);

        if ($version) {
            $client->setVersion($version);
        }

        return $client;
    }
}