<?php
/**
 * File contains class SearchApiParams
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;
use InvalidArgumentException;

/**
 * Class SearchApiParams
 *
 * @package Application\Twitter\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class SearchApiParams
{
    /**
     * @var array
     */
    protected $geocode = [];

    /**
     * @var array
     */
    protected $hashes = [];

    /**
     * @var array
     */
    protected $defaults
        = [
            'radius' => '50km'
        ];

    /**
     * @param $lat
     * @param $lon
     * @param $radius
     *
     * @return SearchApiParams
     */
    public function setGeocode($lat, $lon, $radius)
    {
        $this->geocode = [$lat, $lon, $radius];

        return $this;
    }

    /**
     * @return string
     */
    public function geocodeToString()
    {
        return implode(',', $this->geocode);
    }

    /**
     * @param string $hash
     *
     * @return SearchApiParams
     */
    public function addHash($hash)
    {
        array_push($this->hashes, $hash);

        return $this;
    }

    /**
     * @return string
     */
    public function hashesToString()
    {
        $prefixed = array_map(
            function ($el) {
                return '#' . $el;
            },
            $this->hashes
        );

        return implode('', $prefixed);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $postfix = 'ToString';
        $out     = [];

        foreach ($this as $attr => $value) {
            if ($attr === 'defaults') {
                continue;
            }

            $method = $attr . $postfix;
            $value  = method_exists($this, $method) ? $this->$method() : $value;

            if (empty($value)) {
                continue;
            }

            $out[$attr] = $value;
        }

        return $out;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setDefaults($key, $value)
    {
        if (!array_key_exists($key, $this->defaults)) {
            throw new InvalidArgumentException(
                sprintf('Parameter %s is not supported', $key)
            );
        }

        $this->defaults[$key] = $value;
    }

    /**
     * @param array $params
     *
     * @return SearchApiParams
     */
    public function fromRequest(array $params)
    {
        $lat    = isset($params['lat']) ? $params['lat'] : null;
        $lon    = isset($params['lon']) ? $params['lon'] : null;
        $radius = isset($params['radius']) ? $params['radius'] : $this->defaults['radius'];

        if (isset($lat) && isset($lon)) {
            $this->setGeocode($lat, $lon, $radius);
        }

        return $this;
    }

}