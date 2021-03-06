<?php

namespace AppBundle\Repository;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends \Doctrine\ORM\EntityRepository
{
    public function getGamersWithRank()
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->select('t', 'g', 'r', 'tier', 'd')
            ->leftJoin('t.gamers', 'g')
            ->leftJoin('g.rank', 'r')
            ->leftJoin('r.tier', 'tier')
            ->leftJoin('r.division', 'd')
            ->addOrderBy('t.name', 'asc')
            ->addOrderBy('g.id', 'asc')
        ;
        return $qb->getQuery()->getResult();
    }
}
