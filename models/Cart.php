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
        $cart = $_SESSION['cart'];
        
        foreach ($cart as $id =>$qt){
            $info = $products->getInfo($id);
            $array[] = array(
                'id' => $id,
                'qt' => $qt,
                'price' => $info['price'],
                'name' => $info['name'],
                'image' => $info['image']
            );
            
        }
        
        return $array;
    }
}
