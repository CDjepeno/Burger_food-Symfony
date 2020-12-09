<?php
namespace App\Cart;

use App\Cart\CartItem;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $productRepo;

    public function __construct(SessionInterface $session, ProductRepository $productRepo)
    {
        $this->session = $session;
        $this->productRepo = $productRepo;
    }

    protected function getCart(): array
    {
        return $this->session->get("cart",[]);
    }

    protected function saveCart(array $cart)
    {
        return $this->session->set("cart",$cart);
    }

    public function empty()
    {
        $this->saveCart([]);
    }

    /**
     * Permet d'ajouter un produit au panier
     *
     * @param integer $id
     * 
     * @return void
     */
    public function add(int $id): void
    {
        $cart = $this->getCart();
        
        if(!array_key_exists($id, $cart)){
            $cart[$id] = 0;
        }
        
        $cart[$id]++;
     
        $this->saveCart($cart);
    }

    /**
     * Permet de calculer le total du panier
     *
     * @return integer
     */
    public function getTotal(): int
    {
        $total = 0;

        foreach($this->getCart() as $id => $quantity ) {
            $product = $this->productRepo->find($id);

            if(!$product){
                continue;
            }
            $total += ($product->getPrice() * $quantity);
        }

        return $total;
    }

    /**
     * Permet d'avoir le detail du panier
     *
     * @return CartItem[]
     */
    public function getDetailedCart(): array
    {
        $cartDetailed = [];

        foreach($this->getCart() as $id => $quantity ) {
            $product = $this->productRepo->find($id);
            
            if(!$product){
                continue;
            }
            
            $cartDetailed[]= new CartItem($product, $quantity);

        }

        return $cartDetailed;
    }

    /**
     * Permet de supprimer un produit au panier
     *
     * @param [int] $id
     * 
     * @return void
     */
    public function remove(int $id): void
    {
        $cart = $this->getCart();

        unset($cart[$id]);

        $this->saveCart($cart);
    }

    /**
     * Permet de décrémenter un produit du panier
     *
     * @param [int] $id
     * 
     * @return void
     */
    public function decrement(int $id): void
    {
        $cart = $this->getCart();

        if(!array_key_exists($id,$cart)){
            return;
        }

        // Si le produit est à 1 dans notre panier ont le supprime
        if($cart[$id] === 1) {
            $this->remove($id);
            return;
        }
        //  Sinon de décrémenter de 1
        $cart[$id]--;

        $this->saveCart($cart);

    }
}