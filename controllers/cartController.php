<?php

/**
 * cartController [ TIPO ]
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class cartController extends Controller {

    private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $cart = new Cart();
        $cep = '';
        $shipping = array();
        
        if(!empty($_POST['cep'])){
            $cep = intval($_POST['cep']);
            
            $shipping = $cart->shippingCalculate($cep);
            $_SESSION['shipping'] = $shipping;
        }
        
        if(!empty($_SESSION['shipping'])){
            $shipping = $_SESSION['shipping'];
        }
        
        if(!isset($_SESSION['cart']) || (isset($_SESSION['cart'])&& count($_SESSION['cart'])==0)){
            header("Location: " . BASE_URL);
            exit;
        }

        $dados = $store->getTemplateData();
        $dados['shipping'] = $shipping;
        $dados['list'] = $cart->getList();



        $this->loadTemplate('cart', $dados);
    }
    
    
    
    

    public function add() {
        unset($_SESSION['shipping']);
        if (!empty($_POST['id_product'])) {
            $id = intval($_POST['id_product']);
            $qt = intval($_POST['qt_product']);
            

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qt;
            } else {
                $_SESSION['cart'][$id] = $qt;
            }
        }
        //print_r($_SESSION);exit;
        header("Location: " . BASE_URL . "cart");
        exit;
    }
    
    
    public function del($id){
        if(!empty($id)){
            unset($_SESSION['cart'][$id]);
            unset($_SESSION['shipping']);
            header("Location: ".BASE_URL."cart");
            exit;
        }
    }

}
