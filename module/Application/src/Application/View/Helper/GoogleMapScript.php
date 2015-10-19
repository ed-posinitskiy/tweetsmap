<?php
/**
 * File contains class GoogleMapScript
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;


/**
 * Class GoogleMapScript
 *
 * @package Application\View\Helper
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
class GoogleMapScript extends AbstractHelper
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * GoogleMapScript constructor.
     *
     * @param string $source
     * @param string $apiKey
     */
    public function __construct($source, $apiKey = null)
    {
        $this->source = $source;
        $this->apiKey = $apiKey;
    }

    public function __invoke($callback)
    {
        $params = array_filter(['key' => $this->apiKey, 'libraries' => 'places', 'callback' => $callback]);
        $uri = $this->source . '?' . http_build_query($params);

        $this->getView()->inlineScript()->appendFile($uri, 'text/javascript', ['async', 'defer']);
    }
}