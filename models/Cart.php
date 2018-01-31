<?php

/**
 * Cart [ TIPO ]
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class Cart extends Model {
    
    public function getList(){
        $products = new Products();
        $array = array();
        $cart = array();
        if(isset($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
        }
        
        
        foreach ($cart as $id =>$qt){
            $info = $products->getInfo($id);
            $array[] = array(
                'id' => $id,
                'qt' => $qt,
                'price' => $info['price'],
                'name'  => $info['name'],
                'image' => $info['image']
            );
        }
        
        return $array;
    }
    
    
    public function getSubtotal(){
        $list = $this->getList();
        $subtotal = 0;
        
        foreach ($list as $item){
            $subtotal += (floatval($item['price']) * intval($item['qt']));
        }
        
        return $subtotal;
    }
    
    
    /*
     * Calcular o frete
     */
    public function shippingCalculate($cep){
        $array = array(
            'price' => 0,
            'date' => ''
        );
        
        global $config;
        $data = array(
            'nCdServico' => '40010',
            'sCepOrigem' => $config['cep_origem'],
            'sCepDestino' => $cepDestination,
            'nVlPeso' => '',
            'nCdFormato' => '1',
            'nVlComprimento' => '',
            'nVlAltura' => '',
            'nVlLargura' => '',
            'nVlDiametro' => '',
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => '',
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        );
        
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
        $data = http_build_query($data);
        
        $ch = curl_init($url.'?'.$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        $r = simplexml_load_string($r);
        
        $array['price'] = $r->cServico->Valor;
        $array['date'] = $r->cServico->PrazoEntrega;
        
        return $array;
    }
}
