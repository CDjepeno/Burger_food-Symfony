<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

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

        // Nous gérons les utilisateurs
        $users  = [];
        $genres = ['male','female'];
        for ($i=1; $i<=10; $i++) {

            $user      = new Customer;
            $genre     = $faker->randomElement($genres);
            $hash      = $this->encoder->encodePassword($user, 'password');

            $user->setUserName($faker->firstname($genre))
                 ->setSlug(strtolower($this->slugger->slug($user->getUsername())))
                 ->setEmail($faker->email)
                 ->setPassword($hash)
                 ->setRoles("ROLE_USER");

            $manager->persist($user);

            $users[] = $user;
        }

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
                    $imageP          = "https://dummyimage.com/600x400/" . $backgroundColor . "/". $foregroundColor ."&text=" . "photos appartement" ;
                    $content         =  $faker->sentence(5);
                    
                    // Ont met le -1 car ont commence a 0
                    $user = $users[mt_rand(0, count($users) -1)];

                    $product->setName($title)
                        ->setImage($imageProduct)
                        ->setDescription($content)
                        ->setPrice(mt_rand(5, 15))
                        ->setCategory($category)
                        ->setSlug(strtolower($this->slugger->slug($product->getName())));
                    $manager->persist($product);

                    // Gestions des commandes.
                    // for($r=1; $r <= mt_rand(0, 10); $r++) {
                    //     $order = new Order();

                    //     $order = new Orderdetails();

                    //     $createdAt = $faker->dateTimeBetween('-6 months');
                      
                    //     $amount    = $car->getPrice() * $duration;

                    //     $booker    = $users[mt_rand(0,count($users) -1)];

                    //     $order->setCreatedAt($createdAt)
                    //             ->setAmount($amount)
                    //             ->setCustomer($booker)
                    //             ->setProduct($product);

                    //     $manager->persist($order);
                    // }
                }
            }   
        $manager->flush();
    }

}
