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

        $dados = $store->getTemplateData();



        $this->loadTemplate('cart', $dados);
    }

    public function add() {
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
        header("Location: " . BASE_URL . "cart");
        exit;
    }

}
