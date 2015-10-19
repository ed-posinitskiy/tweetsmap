<?php
/**
 * File contains class SearchHistoryRepository
 *
 * @author ma4eto <eddiespb@gmail.com>
 * @since  19.10.2015
 */

namespace Application\Repository;

use Application\Entity\Identity;
use Doctrine\ORM\EntityRepository;

/**
 * Class SearchHistoryRepository
 *
 * @package Application\Repository
 * @author  ma4eto <eddiespb@gmail.com>
 * @since   19.10.2015
 */
class SearchHistoryRepository extends EntityRepository
{
    public function findRecentByIdentity(Identity $identity, $limit = null)
    {
        $qb = $this->createQueryBuilder('h')
                   ->where('h.identity = :identity')
                   ->setParameter('identity', $identity)
                   ->addGroupBy('h.keyword')
                   ->addOrderBy('h.date', 'DESC');

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}