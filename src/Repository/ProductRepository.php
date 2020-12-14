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
     * Permet de récupérer les produits en fonction d'une recherche
     * 
     * @return Product[]
     */
    public function getProductsBySearch($data)
    {
        return $this->createQueryBuilder("p")
                    ->select("p")
                    ->where("p.name = :val")
                    ->setParameter(':val', $data)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Permet de calculer le nombre d'articles les plus commandé
     *
     * @param integer $limit
     * @return void
     */
    public function findBestProductSale() {
        return $this->createQueryBuilder('p')
                    ->join('p.purchaseItems', 'pp')
                    ->select(' p as product ,SUM(pp.quantity) as sumQuantity')
                    ->groupBy('p') 
                    ->orderBy('sumQuantity','DESC')
                    ->setMaxResults(6)
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
