<?php
/**
 * File contains class SearchCacheApiFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Factory\Api;

use Application\Twitter\Api\Search\SearchApi;
use Application\Twitter\Api\Search\SearchCacheApi;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\Cache\StorageFactory;

/**
 * Class SearchCacheApiFactory
 *
 * @package Application\Twitter\Factory\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class SearchCacheApiFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('Config');
        $config = isset($config['search_api']) && is_array($config['search_api']) ? $config['search_api'] : [];

        $cacheEnabled = isset($config['cache']['enabled']) && $config['cache']['enabled'] === true;

        /** @var SearchApi $searchApi */
        $searchApi = $container->get('Application\\Twitter\\Api\\Search\\SearchApi');

        if (!$cacheEnabled) {
            return $searchApi;
        }

        $ttl = $config['cache']['ttl'];
        unset($config['cache']['ttl']);

        $cacheConfig                              = $config['cache'];
        $cacheConfig['adapter']['options']['ttl'] = $ttl;

        $cache = StorageFactory::factory($cacheConfig);

        /** @var EntityManager $em */
        $em = $container->get('Doctrine\\ORM\\EntityManager');

        return new SearchCacheApi($searchApi, $cache, $em);
    }
}