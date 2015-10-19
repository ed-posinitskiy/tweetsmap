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
     * @return HydratorInterface
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param HydratorInterface $hydrator
     *
     * @return SearchApi
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function tweets(SearchApiParams $params, $hydrateAs = self::HYDRATE_OBJECT)
    {
        $headers = $this->getAuthHeader();

        $response = $this->client->get($this->tweetsUrl, $params->getParams(), $headers);

        if (!$response->isSuccess()) {
            throw new RuntimeException('Failed to request tweets by given params');
        }

        $body     = $response->getBody();
        $entries  = $body['statuses'];
        $metaData = $body['search_metadata'];

        if (0 == $metaData['count']) {
            return [];
        }

        $list = [];
        foreach ($entries as $entry) {
            $tweet = new Tweet();
            $this->hydrator->hydrate($entry, $tweet);

            array_push($list, $tweet);
        }

        return $this->hydrateTweetsResponse($list, $hydrateAs);
    }

    /**
     * @param Tweet[]  $tweets
     * @param string $hydrateAs
     *
     * @return array
     */
    public function hydrateTweetsResponse(array $tweets, $hydrateAs)
    {
        $hydrateAs = ($hydrateAs === self::HYDRATE_OBJECT) ? self::HYDRATE_OBJECT : self::HYDRATE_ARRAY;

        switch ($hydrateAs) {
            case self::HYDRATE_OBJECT:
                return $tweets;
                break;
            default:
                if (!$this->hydrator) {
                    throw new RuntimeException('Hydrator must be defined to use hydrate as array property');
                }

                return array_map([$this->hydrator, 'extract'], $tweets);
                break;
        }
    }
}