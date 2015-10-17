<?php
/**
 * File contains interface ClientInterface
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  17.10.2015
 */

namespace Application\Twitter;


/**
 * Interface ClientInterface
 *
 * @package Application\Twitter
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   17.10.2015
 */
interface ClientInterface
{

    /**
     * @param float $version
     *
     * @return void
     */
    public function setVersion($version);

    /**
     * @param SearchParams $params
     *
     * @return mixed
     */
    public function search(SearchParams $params);

}