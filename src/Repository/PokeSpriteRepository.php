<?php

namespace App\Repository;

use App\Entity\PokeSprite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PokeSprite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokeSprite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokeSprite[]    findAll()
 * @method PokeSprite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokeSpriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PokeSprite::class);
    }

//    /**
//     * @return PokeSprite[] Returns an array of PokeSprite objects
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
    public function findOneBySomeField($value): ?PokeSprite
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
