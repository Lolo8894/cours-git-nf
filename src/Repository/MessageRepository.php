<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Message;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
       // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    
    public function sortedByIdWithMax(User $userConnected, int $nbmaxMessage = 2)
    {
        return $this->createQueryBuilder('m')
            ->where('m.sender = :idUser or m.receiver = :idUser')
            ->setParameter('idUser', $userConnected->getId())

            ->orderBy('m.id', 'Desc')
            ->setMaxResults($nbmaxMessage)
            ->getQuery()
            ->getResult()
        ;
    } 
}
