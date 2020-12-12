<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder; 
    private $slugger; 

    public function __construct(UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
        $this->encoder = $encoder;
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager)
    {
        $faker     = Factory::create('FR-fr');
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        // Nous gérons les utilisateurs
        $users  = [];
        $genres = ['male','female'];
        for ($i=1; $i<=10; $i++) {

            $user      = new Customer;
            $genre     = $faker->randomElement($genres);
            $hash      = $this->encoder->encodePassword($user, 'password');

            $user->setUserName($faker->firstname($genre))
                //  ->setSlug(strtolower($this->slugger->slug($user->getUsername())))
                 ->setEmail($faker->email)
                 ->setPassword($hash)
                 ->setRoles("ROLE_USER");

            $manager->persist($user);

            $users[] = $user;
        }

        $products = [];

        // Nous gérons les catégory
        $categories = ['burger','snack','salade','dessert','menu','drink'];
            foreach ($categories as $cat) {
                $category = new Category;

                $category->setName($cat); 
                $manager ->persist($category);

                // Nous gérons les produits
                for ($j=0; $j<= mt_rand(3,5); $j++) {
                    $product = new Product();

                    $title           = $faker->sentence(2);
                    $backgroundColor = trim($faker->safeHexcolor, '#');
                    $foregroundColor = trim($faker->safeHexcolor, '#');
                    $imageProduct    = "https://dummyimage.com/600x400/" . $backgroundColor . "/". $foregroundColor ."&text=" . "produit" ;
                    $imageP          = "https://picsum.photos/400/300";
                    $content         =  $faker->sentence(5);
                    
                    // Ont met le -1 car ont commence a 0
                    $user = $users[mt_rand(0, count($users) -1)];

                    $product->setName($title)
                        ->setImage($faker->imageUrl(400,400, true))
                        ->setDescription($content)
                        ->setPrice(mt_rand(5, 15))
                        ->setCategory($category);

                    $products[]= $product;

                    $manager->persist($product);
                }
                //  Gestions des commandes.
                    for($r=1; $r <= mt_rand(0, 10); $r++) {
                        $purchase = new Purchase();
                      
                        $customer = $users[mt_rand(0,count($users) -1)];

                        $purchase ->setAdress($faker->streetAddress)
                                  ->setPostalCode(mt_rand(75000,75020))
                                  ->setCity($faker->city)
                                  ->setFullname($customer->getUsername())
                                  ->setAmount(mt_rand(10,80))
                                  ->setPurchaseAt($faker->dateTimeBetween("-6 month"))
                                  ->setCustomer($customer);

                            $selectedProducts = $faker->randomElements($products, mt_rand(3 , 4));

                            foreach($selectedProducts as $product) {
                                $purchaseItem = new PurchaseItem;
                                $purchaseItem ->setProduct($product)
                                              ->setQuantity(mt_rand(1,3))
                                              ->setProductName($product->getName())
                                              ->setProductPrice($product->getPrice())
                                              ->setAmount(
                                                  $purchaseItem->getProductPrice() * $purchaseItem->getQuantity()
                                                )
                                              ->setPurchase($purchase);

                                $manager->persist($purchaseItem);

                            }

                              if($faker->boolean(70)){
                                  $purchase->setStatus(Purchase::STATUS_PAID);

                              }
                        $manager->persist($purchase);
                    }
            }   
        $manager->flush();
    }

}
