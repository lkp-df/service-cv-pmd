<?php 
namespace App\Service\Cart;

use App\Repository\AbonnementRepository;
use App\Repository\ArticleRepository;
use App\Repository\TypeAbonnementRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartAbonnementService{
    private $session;
    private $typeAbonnementRepository;
    public function __construct(SessionInterface $sessionInterface, TypeAbonnementRepository $typeAbonnementRepository)
    {
        $this->session =$sessionInterface;
        
        $this->typeAbonnementRepository = $typeAbonnementRepository;
    }
    public function addPost(int $id)
    {       
        $this->session->set('panier_abonnement',$id);   
    }
    public function add(int $id)
    {
        $this->session->set('panier_abonnement',$id);
        
    }
    public function remove(int $id)
    {    
        $this->session->set('panier_abonnement',null);   
    }
    public function delete(int $id)
    {
        $this->session->set('panier_abonnement',null);
    }
    public function clear()
    {
        $this->session->set('panier_abonnement',[]);
    }
    public function getCart(){
    
        $id  = $this->session->get('panier_abonnement');
        return $this->typeAbonnementRepository->find($id);
    }
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier_abonnement',[]);
        $panierWithData = [];
        foreach($panier as $id => $quantite){
            $panierWithData[]=[
                'abonnement'=>$this->typeAbonnementRepository->find($id),
                // 'quantite'=>$quantite
            ];
        }
        return $panierWithData;
    }
    public function getTotal():float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item) {
                $total+= $item['abonnement']->getNewPrice() * $item['abonnement']->getMontant();
        }
        return $total;
    }

}