<?php

namespace App\Repository;

use App\Entity\Appartement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Appartement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appartement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appartement[]    findAll()
 * @method Appartement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appartement::class);
    }
 
/**
     * @return Appartement[] Returns an array of Appartement objects
     */
    
    public function findByField($type,$prix,$a1,$a2,$a3,$a4,$datearr)
    {
        //retourne les propositions d'appartements qui font suite à une demande du client
        return $this->createQueryBuilder('a')
            ->andWhere('a.dateLibre < :datearr ')
            ->andWhere('a.type = :type')
            ->andWhere('a.arrondissement = :a1 OR a.arrondissement = :a2 OR a.arrondissement = :a3 OR a.arrondissement = :a4')
            ->andWhere('a.prixLoc <= :prix')
            ->setParameter('datearr', $datearr)
            ->setParameter('type', $type)
            ->setParameter('a1', $a1)
            ->setParameter('a2', $a2)
            ->setParameter('a3', $a3)
            ->setParameter('a4', $a4)
            ->setParameter('prix', $prix)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Appartement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
