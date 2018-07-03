<?php

namespace App\Repository;

use App\Entity\TFS04\PlayerSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlayerSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerSkill[]    findAll()
 * @method PlayerSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerSkillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerSkill::class);
    }

//    /**
//     * @return PlayerSkill[] Returns an array of PlayerSkill objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerSkill
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
