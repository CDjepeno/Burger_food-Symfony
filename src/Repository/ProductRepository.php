<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Récupère les véhicules par leurs catégories
     *
     * @param [type] $id_category
     * @return Car[]
     */
    public function getProductByCategory($id_category)
    {
        return $this->createQueryBuilder('p')
                    ->join('p.category', 'p_c')
                    ->select('p')
                    ->where('p_c.id = :cat')
                    ->setParameter(':cat', $id_category)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Permet de récupérer les produits de la catégorie menu
     * 
     * @return Product[]
     */
    public function getProductsByMenu()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "menu")
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Permet de récupérer les produits de la catégorie burger
     * 
     * @return Product[]
     */
    public function getProductsByBurger()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "burger")
                    ->getQuery()
                    ->getResult();
    }
    /**
     * Permet de récupérer les produits de la catégorie snack
     * 
     * @return Product[]
     */
    public function getProductsBySnack()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "snack")
                    ->getQuery()
                    ->getResult();
    }
    /**
     * Permet de récupérer les produits de la catégorie salade
     * 
     * @return Product[]
     */
    public function getProductsBySalade()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "salade")
                    ->getQuery()
                    ->getResult();
    }
    /**
     * Permet de récupérer les produits de la catégorie drink
     * 
     * @return Product[]
     */
    public function getProductsByDrink()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "drink")
                    ->getQuery()
                    ->getResult();
    }
    /**
     * Permet de récupérer les produits de la catégorie dessert
     * 
     * @return Product[]
     */
    public function getProductsByDessert()
    {
        return $this->createQueryBuilder("p")
                    ->leftJoin("p.category", "p_c")
                    ->select("p")
                    ->where("p_c.name = :val")
                    ->setParameter(':val', "dessert")
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
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
    public function findOneBySomeField($value): ?Product
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
