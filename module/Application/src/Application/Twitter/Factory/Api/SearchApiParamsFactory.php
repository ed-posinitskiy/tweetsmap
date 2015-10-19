<?php
/**
 * File contains class SearchApiParamsFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  19.10.2015
 */

namespace Application\Twitter\Factory\Api;

use Application\Twitter\Api\Search\SearchApiParams;
use Interop\Container\ContainerInterface;

/**
 * Class SearchApiParamsFactory
 *
 * @package Application\Twitter\Factory\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   19.10.2015
 */
class SearchApiParamsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('Config');
        $config = isset($config['search_api']) && is_array($config['search_api']) ? $config['search_api'] : [];

        $params = new SearchApiParams();

        if (isset($config['radius'])) {
            $params->setDefaults('radius', $config['radius']);
        }

        return $params;
    }
}