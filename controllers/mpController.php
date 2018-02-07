<?php

/**
 * mpController [ TIPO ]
 *
 * @author geral
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class mpController extends Controller {

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
                $mp = new MP($config['mp_appid'], $config['mp_key']);

                $data = array(
                    'items' => array(),
                    'shipments' => array(
                        'mode' => 'custom',
                        'cost' => $frete,
                        'receiver_address' => array(
                            'zip_code' => $cep
                        )
                    ),
                    'back_urls' => array(
                        'success' => BASE_URL . 'mp/obrigadoaprovado',
                        'pending' => BASE_URL . 'mp/obrigadoanalise',
                        'failure' => BASE_URL . 'mp/obrigadocancelado'
                    ),
                    'notification' => BASE_URL . 'mp/',
                    'auto_return' => 'all',
                    'external_reference' => $id_purchase
                );

                foreach ($list as $item) {
                    $data['items'][] = array(
                        'title' => $item['name'],
                        'quantity' => $item['qt'],
                        'currency_id' => 'BRL',
                        'unit_price' => floatval($item['price'])
                    );
                }

                $link = $mp->create_preference($data);

                /* echo '<pre>';
                  print_r($link);
                  exit; */
                //$link = $link['init_point'];

                if ($link['status'] == '201') {
                    $link = $link['response']['init_point'];
                    header("Location: " . $link);
                    exit;
                } else {
                    $dados['error'] = 'Tente novamente mais tarde!';
                }
            }
        }

        $this->loadTemplate('cart_mp', $dados);
    }

    public function notificacao() {
        global $config;
        $mp = new MP($config['mp_appid'], $config['mp_key']);
    }

}
