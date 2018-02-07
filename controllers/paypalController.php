<?php

/**
 * paypalController [ TIPO ]
 * Descricao
 * @copyright (c) year, Silvio Coelho CURSO UPINSIDE TECNOLOGIA
 */
class paypalController extends Controller {
        private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $users = new Users();
        $cart = new Cart();
        $purchases = new Purchases();
        $dados = $store->getTemplateData();
        $dados['error'] = '';

        if (!empty($_POST['name'])) {
            $name = addslashes($_POST['name']);
            $cpf = addslashes($_POST['cpf']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $pass = addslashes($_POST['pass']);
            $cep = addslashes($_POST['cep']);
            $rua = addslashes($_POST['rua']);
            $numero = addslashes($_POST['numero']);
            $complemento = addslashes($_POST['complemento']);
            $bairro = addslashes($_POST['bairro']);
            $cidade = addslashes($_POST['cidade']);
            $estado = addslashes($_POST['estado']);

            if ($users->emailExists($email)) {
                $uid = $users->validate($email, $pass);

                if (empty($uid)) {
                    $dados['error'] = 'E-mail e/ou senha não conferem!';
                    exit;
                }
            } else {
                $uid = $users->createUser($email, $pass);
            }

            if (!empty($uid)) {

                $list = $cart->getList();

                $frete = 0;

                $total = 0;
                foreach ($list as $item) {
                    $total += (floatval($item['price']) * intval($item['qt']));
                }
                if (!empty($_SESSION['shipping'])) {
                    $shipping = $_SESSION['shipping'];
                    if (isset($shipping['price'])) {
                        $frete = floatval(str_replace(',', '.', $shipping['price']));
                    } else {
                        $frete = 0;
                    }
                    $total += $frete;
                }

                try {
                    $id_purchase = $purchases->createPurchase($uid, $total, 'mp');
                } catch (Exception $ex) {
                    $dados['error'] = $ex->getMessage();
                    exit;
                }


                try {
                    foreach ($list as $item) {
                        $purchases->addItem($id_purchase, $item['id'], $item['qt'], $item['price']);
                    }
                } catch (Exception $ex) {
                    $dados['error'] = $ex->getMessage();
                    exit;
                }

                global $config;
                /*
                 * integração paypal
                 */
                
                
            }
        }

        $this->loadTemplate('cart_paypal', $dados);
    }



}