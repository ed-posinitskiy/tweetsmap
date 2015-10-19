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
        $config = $container->get('Config');
        $config = isset($config['twitter']) && is_array($config['twitter']) ? $config['twitter'] : [];

        if (empty($config['api_endpoint'])) {
            throw new RuntimeException(
                'Twitter API endpoint must be defined under twitter.api_endpoint config'
            );
        }

        $endpoint = $config['api_endpoint'];
        $version  = isset($config['api_version']) ? $config['api_version'] : null;

        $httpClient = new HttpClient();
        $client     = new Client($httpClient, $endpoint);

        if ($version) {
            $client->setVersion($version);
        }

        return $client;
    }
}