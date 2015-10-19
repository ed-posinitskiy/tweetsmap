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
    public function tweets(SearchApiParams $params)
    {
        $hash = $this->getHashedKey($params);

        if ($this->storage->hasItem($hash)) {
            $repository = $this->objectManager->getRepository(Tweet::class);
            $tweets     = $repository->findBy(['id' => $this->storage->getItem($hash)]);

            if (empty($tweets)) {
                return $this->doTweets($params);
            }

            return $tweets;
        }

        return $this->doTweets($params);
    }

    protected function doTweets(SearchApiParams $params)
    {
        $hash   = $this->getHashedKey($params);
        $ids    = [];
        $tweets = $this->api->tweets($params);

        foreach ($tweets as $tweet) {
            $this->objectManager->persist($tweet);
            $this->objectManager->flush();

            $ids[] = $tweet->getId();
        }


        $this->storage->setItem($hash, $ids);

        return $tweets;
    }

    protected function getHashedKey(SearchApiParams $params)
    {
        return md5(implode('.', $params->getParams()));
    }

}