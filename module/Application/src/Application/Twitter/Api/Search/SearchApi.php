<?php
/**
 * File contains class SearchApi
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;

use Application\Entity\Tweet;
use Application\Twitter\Api\AbstractApi;
use RuntimeException;
use Zend\Hydrator\HydratorInterface;

/**
 * Class SearchApi
 *
 * @package Application\Twitter\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class SearchApi extends AbstractApi implements SearchApiInterface
{

    /**
     * @var string
     */
    protected $tweetsUrl = '/search/tweets.json';

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @inheritdoc
     */
    public function tweets(SearchApiParams $params)
    {
        $headers = $this->getAuthHeader();

        $response = $this->client->get($this->tweetsUrl, $params->getParams(), $headers);

        if (!$response->isSuccess()) {
            throw new RuntimeException('Failed to request tweets by given params');
        }

        if (0 == $response->getBody()->statuses) {
            return [];
        }

        $list = [];
        foreach ($response->getBody()->statuses as $message) {
            $tweet = new Tweet();
            $this->hydrator->hydrate((array)$message, $tweet);

            array_push($list, $tweet);
        }

        return $list;
    }
}