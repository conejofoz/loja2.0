<?php

/**
 * buscaController [ TIPO ]
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class productController extends Controller {

    private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function open($id) {
        $store = new Store();
        $products = new Products();
        $categories = new Categories();
        
        $dados = $store->getTemplateData();
        
        $info = $products->getProductInfo($id);
        if (count($info) > 0) {
            
            $dados['product_info'] = $info;
            $dados['product_images'] = $products->getImagesByProductsId($id);
            $dados['product_options'] = $products->getOptionsByProductId($id);
            $dados['product_rates'] = $products->getRates($id, 5);


          
            
            
           



            $this->loadTemplate('product', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }

}
