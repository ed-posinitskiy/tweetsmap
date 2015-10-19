<?php
/**
 * File contains class HistoryTracker
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  18.10.2015
 */

namespace Application\Service;

use Application\Auth\AuthenticationStorage;
use Application\Entity\SearchHistory;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class HistoryTracker
 *
 * @package Application\Service
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   18.10.2015
 */
class HistoryTracker
{
    /**
     * @var AuthenticationStorage
     */
    protected $authStorage;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * HistoryTracker constructor.
     *
     * @param AuthenticationStorage $authStorage
     * @param ObjectManager         $objectManager
     */
    public function __construct(AuthenticationStorage $authStorage, ObjectManager $objectManager)
    {
        $this->authStorage   = $authStorage;
        $this->objectManager = $objectManager;
    }

    /**
     * Saves given search keyword for current identity
     * If Identity is not present, will do nothing
     *
     * @param string $keyword
     */
    public function save($keyword)
    {
        if (!$this->authStorage->hasIdentity()) {
            return;
        }

        $entry = new SearchHistory();
        $entry->setKeyword($keyword);
        $entry->setIdentity($this->authStorage->getIdentity());

        $this->objectManager->persist($entry);
        $this->objectManager->flush();
    }

    /**
     * Tries to find recent (sorted by date => DESC) search history entries for current Identity
     * If identity is not present will return empty array
     *
     * @param int $limit
     *
     * @return array
     */
    public function findRecent($limit = null)
    {
        if (!$this->authStorage->hasIdentity()) {
            return [];
        }

        $identity = $this->authStorage->getIdentity();
        $repo     = $this->objectManager->getRepository(SearchHistory::class);

        return $repo->findRecentByIdentity($identity, $limit);
    }
}