<?php
/**
 * File contains interface SearchApiInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;

/**
 * Interface SearchApiInterface
 *
 * @package Application\Twitter\Api\Search
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
interface SearchApiInterface
{

    const HYDRATE_ARRAY  = 'array';
    const HYDRATE_OBJECT = 'object';

    /**
     * @param SearchApiParams $params
     * @param string          $hydrateAs
     *
     * @return array
     */
    public function tweets(SearchApiParams $params, $hydrateAs = self::HYDRATE_OBJECT);
}