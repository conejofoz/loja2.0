<?php

/**
 * Filters [ TIPO ]
 * Descricao
 * @copyright (c) 2018, Silvio Coelho 
 */
class Filters extends Model {
    public function getFilters($filters){
        $products = new Products();
        $brands = new Brands();
        $array = array(
            'brands' => array(),
            'maxslider' => 1000,
            'stars' => array(),
            'sale' => false,
            'options' =>array()
        );
        
        $array['brands'] = $brands->getList();
        $brand_products = $products->getListOfBrands($filters);
        
        foreach ($array['brands'] as $bkey => $bitem){
            
            $array['brands'][$bkey]['count'] = '0';
            
            foreach ($brand_products as $bproduct){
                if($bproduct['id_brand'] == $bitem['id']){
                    $array['brands'][$bkey]['count'] = $bproduct['c'];
                }
            }
            if($array['brands'][$bkey]['count']=='0'){
                unset($array['brands'][$bkey]);
            }
        }
        
        
        return $array;
    }
}