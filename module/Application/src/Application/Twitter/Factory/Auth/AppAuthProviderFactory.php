<?php
/**
 * File contains class AppAuthProviderFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Factory\Auth;

use Application\Twitter\Auth\AppAuthProvider;
use Application\Twitter\Auth\TokenStorageInterface;
use Application\Twitter\Client;
use Interop\Container\ContainerInterface;
use RuntimeException;

/**
 * Class AppAuthProviderFactory
 *
 * @package Application\Twitter\Factory\Auth
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class AppAuthProviderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var Client $client */
        $client = $container->get('twitter.client');
        /** @var TokenStorageInterface $tokenStorage */
        $tokenStorage = $container->get('twitter.auth.token-storage');

        $config = $container->get('Config');
        $config = isset($config['twitter']) && is_array($config['twitter']) ? $config['twitter'] : [];

        if (empty($config['api_key'])) {
            throw new RuntimeException(
                'Twitter API key must be defined under twitter.api_key config'
            );
        }

        if (empty($config['api_secret'])) {
            throw new RuntimeException(
                'Twitter API secret must be defined under twitter.api_secret config'
            );
        }

        return new AppAuthProvider($client, $tokenStorage, $config['api_key'], $config['api_secret']);
    }
}