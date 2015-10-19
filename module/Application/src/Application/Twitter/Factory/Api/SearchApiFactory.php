<?php
/**
 * File contains class SearchApiFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Factory\Api;

use Application\Twitter\Api\Search\SearchApi;
use Application\Twitter\Api\Search\TweetHydrator;
use Application\Twitter\Auth\AuthProviderInterface;
use Application\Twitter\Client;
use Interop\Container\ContainerInterface;

/**
 * Class SearchApiFactory
 *
 * @package Application\Twitter\Factory\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class SearchApiFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var Client $client */
        $client = $container->get('twitter.client');
        /** @var AuthProviderInterface $authProvider */
        $authProvider = $container->get('twitter.auth.auth-provider');

        $api = new SearchApi($client, $authProvider);
        $api->setHydrator(new TweetHydrator());

        return $api;
    }
}