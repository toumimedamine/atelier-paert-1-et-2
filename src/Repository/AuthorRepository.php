<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
     public function OrderByDesc():array
     {
        return $this->createQueryBuilder('a',)
            ->orderBy('a.username', 'DESC')
            ->getQuery()
            ->getResult()
            ;

     }
    public function OrderByDesc1():array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT p FROM App\Entity\Author p ORDER BY  p.username ASC ');
        return $query->getResult();

    }
     public function showBookAuthor($id):array
     {
        return $this->createQueryBuilder('a')
            ->join('a.nb_books','b')
            ->addSelect('b')
            ->where('b.author =: id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult()

            ;
     }
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
