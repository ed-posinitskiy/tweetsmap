<?php
/**
 * File contains class SearchCacheApi
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Twitter\Api;

use Application\Entity\Tweet;
use Application\Twitter\Api\Search\SearchApi;
use Application\Twitter\Api\Search\SearchApiInterface;
use Application\Twitter\Api\Search\SearchApiParams;
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
        $hash = implode('.', $params->getParams());

        if ($this->storage->hasItem($hash)) {
            $repository = $this->objectManager->getRepository(Tweet::class);
            $tweets     = $repository->findBy(['id' => $this->storage->getItem($hash)]);

            return $tweets;
        }

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

}