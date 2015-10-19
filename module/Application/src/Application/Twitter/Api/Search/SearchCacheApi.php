<?php
/**
 * File contains class SearchCacheApi
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api\Search;

use Application\Entity\Tweet;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Cache\Storage\StorageInterface;

/**
 * Class SearchCacheApi
 *
 * @package Application\Twitter\Api
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class SearchCacheApi implements SearchApiInterface
{
    /**
     * @var SearchApi
     */
    protected $api;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * SearchCacheApi constructor.
     *
     * @param SearchApi        $api
     * @param StorageInterface $storage
     * @param ObjectManager    $objectManager
     */
    public function __construct(SearchApi $api, StorageInterface $storage, ObjectManager $objectManager)
    {
        $this->api           = $api;
        $this->storage       = $storage;
        $this->objectManager = $objectManager;
    }


    /**
     * @inheritDoc
     */
    public function tweets(SearchApiParams $params, $hydrateAs = self::HYDRATE_OBJECT)
    {
        $hash = $this->getHashedKey($params);

        if ($this->storage->hasItem($hash)) {
            $repository = $this->objectManager->getRepository(Tweet::class);
            $tweets     = $repository->findBy(['id' => $this->storage->getItem($hash)]);

            if (empty($tweets)) {
                return $this->doTweets($params, $hydrateAs);
            }

            if ($hydrateAs === self::HYDRATE_ARRAY) {
                $tweets = $this->api->hydrateTweetsResponse($tweets, self::HYDRATE_ARRAY);
            }

            return $tweets;
        }

        return $this->doTweets($params, $hydrateAs);
    }

    protected function doTweets(SearchApiParams $params, $hydrateAs)
    {
        $hash   = $this->getHashedKey($params);
        $ids    = [];
        $tweets = $this->api->tweets($params, self::HYDRATE_OBJECT);

        foreach ($tweets as $tweet) {
            $this->objectManager->persist($tweet);
            $this->objectManager->flush();

            $ids[] = $tweet->getId();
        }


        $this->storage->setItem($hash, $ids);

        return $this->api->hydrateTweetsResponse($tweets, $hydrateAs);
    }

    protected function getHashedKey(SearchApiParams $params)
    {
        return md5(implode('.', $params->getParams()));
    }

}