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
        $dados = array();
        $products = new Products();
        $categories = new Categories();
        $f = new Filters();
        $filters = array();

        $info = $products->getProductInfo($id);
        if (count($info) > 0) {
            
            $dados['product_info'] = $info;


            $dados['categories'] = $categories->getList();
            $dados['filters'] = $f->getFilters($filters);
            $dados['filters_selected'] = array();

            $dados['widget_featured1'] = $products->getList(0, 5, array('featured' => 1), true);
            $dados['widget_featured2'] = $products->getList(0, 3, array('featured' => 1), true);
            $dados['widget_sale'] = $products->getList(0, 3, array('sale' => 1), true);
            $dados['widget_toprated'] = $products->getList(0, 3, array('toprated' => 1));



            $this->loadTemplate('product', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }

}
