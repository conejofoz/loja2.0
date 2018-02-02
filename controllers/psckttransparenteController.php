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
        $cart = new cart();
        $dados = $store->getTemplateData();
        
        $list = $cart->getList();
        $total = 0;
        foreach ($list as $item){
            $total += (floatval($item['price']) * intval($item['qt']));
        }
        if(!empty($_SESSION['shipping'])){
            $shipping = $_SESSION['shipping'];
            if(isset($shipping['price'])){
                $frete = floatval(str_replace(',', '.', $shipping['price']));
            } else {
                $frete = 0;
            }
            $total += $frete;
        }
        $dados['total'] = number_format($total, 2);
        

        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                            \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            $dados['sessionCode'] = $sessionCode->getResult();
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
        $this->loadTemplate('cart_psckttransparente', $dados);
    }

    public function checkout() {
        $users = new Users();
        $cart = new Cart();
        $purchases = new Purchases();
        $id = addslashes($_POST['id']);
        $name = addslashes($_POST['name']);
        $cpf = addslashes($_POST['cpf']);
        $email = addslashes($_POST['email']);
        $pass = addslashes($_POST['pass']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        $cartao_titular = addslashes($_POST['cartao_titular']);
        $cartao_cpf = addslashes($_POST['cartao_cpf']);
        $cartao_numero = addslashes($_POST['cartao_numero']);
        $cvv = addslashes($_POST['cvv']);
        $v_mes = addslashes($_POST['v_mes']);
        $v_ano = addslashes($_POST['v_ano']);
        $cartao_token = addslashes($_POST['cartao_token']);

        if ($users->emailExists($email)) {
            $uid = $users->validate($email, $pass);

            if (empty($uid)) {
                $array = array('error'=>true, 'msg'=>'Email e/ou senha nao conferem');
                echo json_encode($array);
                exit;
            }
        } else {
            $uid = $users->createUser($email, $pass);
        }
        $list = $cart->getList();
        $total = 0;
        foreach ($list as $item){
            $total += (floatval($item['price']) * intval($item['qt']));
        }
        if(!empty($_SESSION['shipping'])){
            $shipping = $_SESSION['shipping'];
            if(isset($shipping['price'])){
                $frete = floatval(str_replace(',', '.', $shipping['price']));
            } else {
                $frete = 0;
            }
            $total += $frete;
        }
    }

}
