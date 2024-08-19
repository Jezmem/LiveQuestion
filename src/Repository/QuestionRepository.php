<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findByCategoryWithLimit(string $categoryName, int $limit): array
    {
        return $this->createQueryBuilder('q')
            ->join('q.category', 'c')
            ->where('c.name = :category')
            ->setParameter('category', $categoryName)
            ->orderBy('q.publicationDate', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findRandomQuestions(int $limit): array
    {
        $sql = 'SELECT * FROM question ORDER BY RAND() LIMIT :limit';
        $stmt = $this->connection->prepare($sql);

        // Bind the parameter
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);

        // Execute the query
        $resultSet = $stmt->executeQuery();

        // Fetch results as associative arrays
        return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return Question[] Returns an array of Question objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
