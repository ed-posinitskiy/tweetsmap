<?php
/**
 * File contains class GoogleMapsScriptFactory
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\View\Factory\Helper;

use Application\View\Helper\GoogleMapScript;
use RuntimeException;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

/**
 * Class GoogleMapsScriptFactory
 *
 * @package Application\View\Factory\Helper
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
class GoogleMapsScriptFactory
{

    /**
     * @param HelperPluginManager $container
     *
     * @return GoogleMapScript
     */
    public function __invoke($container)
    {
        /** @var ServiceManager $sm */
        $sm     = $container->getServiceLocator();
        $config = $sm->get('Config');

        if (empty($config['map']['source_url'])) {
            throw new RuntimeException(
                sprintf('Map script url must be defined under `%s` config', 'map.source_url')
            );
        }

        $source = $config['map']['source_url'];
        $apiKey = !empty($config['map']['api_key']) ? $config['map']['api_key'] : null;

        return new GoogleMapScript($source, $apiKey);
    }

}