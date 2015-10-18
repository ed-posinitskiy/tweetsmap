<?php
/**
 * File contains class SearchApiParams
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;

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
     * @param $lat
     * @param $long
     * @param $radius
     *
     * @return SearchApiParams
     */
    public function setGeocode($lat, $long, $radius)
    {
        $this->geocode = [$lat, $long, $radius];

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
            $method = $attr . $postfix;
            $value  = method_exists($this, $method) ? $this->$method() : $value;

            if(empty($value)) {
                continue;
            }

            $out[$attr] = $value;
        }

        return $out;
    }

}