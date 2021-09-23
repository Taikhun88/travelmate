<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Effectue une recherche d'evenement en fonction de la variable
     * $city
     * 
     * Version 1 : Query builder
     *
     * @param $title
     * @return Event[]
     */


    public function searchEventByCity($city, $category)
    {
        // https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/query-builder.html
         $query = $this->createQueryBuilder('event')
            // Clause WHERE pour filtre en fonction de $title
            ->join('event.city', 'city')
            ->join('event.categories', 'category')
            ->where('city.name LIKE :title')
            ->setParameter(':title', "%$city%");
                if (!empty($category)) {
                    
                    $query->andWhere('category.id LIKE :category')
                    ->setParameter(':category', $category);
                };
                return $query
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
