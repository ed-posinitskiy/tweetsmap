<?php
/**
 * File contains interface SearchApiInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;

use Application\Entity\Tweet;

/**
 * Interface SearchApiInterface
 *
 * @package Application\Twitter\Api\Search
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
interface SearchApiInterface
{

    /**
     * @param SearchApiParams $params
     *
     * @return Tweet[]
     */
    public function tweets(SearchApiParams $params);
}