<?php

/**
 * psckttransparenteController [ TIPO ]
 *
 * @author geral
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class psckttransparenteController extends Controller {
    private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $dados = $store->getTemplateData();
        $this->loadTemplate('cart_psckttransparente', $dados);
    }
}
