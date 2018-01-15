<?php

class Products extends Model{
    
    public function getList($offset = 0, $limit = 3, $filters = array()){
        $array = array();
        
        $where = $this->buildWhere($filters);
        
        
        $sql = "SELECT *, "
                . "( select brands.name from brands where brands.id = products.id_brand) "
                . "as brand_name, "
                . "( select categories.name from categories where categories.id = products.id_category) "
                . "as category_name "
                . "FROM products "
                . "WHERE ".implode(' AND ', $where)." LIMIT $offset, $limit ";
        //echo $sql;
        //exit;
        $sql = $this->db->prepare($sql);
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
            foreach ($array as $key => $item){
                $array[$key]['images'] = $this->getImagesByProductsId($item['id']);
            }
        }
        return $array;
    }
    
    
    
    public function getList_usando_model(){
        $array = array();
        /*$sql = "SELECT *, "
                . "( select brands.name from brands where brands.id = products.id_brand)"
                . "as brand_name,"
                . "( select categories.name from categories where categories.id = products.id_category)"
                . "as category_name"
                . " FROM products";
         * 
         */
        $sql = "SELECT * FROM products";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
            $brands = new Brands();
            foreach ($array as $key => $item){
                $array[$key]['brand_name'] = $brands->getNameById($item['id_brand']);
            }
        }
        return $array;
    }
    
    
    
    public function getImagesByProductsId($id){
        $array = array();
        $sql = "SELECT * FROM products_images WHERE id_product = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        
        
        return $array;
    }
    
    
    
    public function getTotal($filters = array()){
        
        
        $where = $this->buildWhere($filters);
        
        $sql = "SELECT COUNT(*) as c FROM products WHERE ".  implode(' AND ', $where);
        $sql = $this->db->prepare($sql);
        $this->bindWhere($filters, $sql);
        $sql->execute();
        $sql = $sql->fetch();
        return $sql['c'];
    }
    
    
    
    public function getListOfBrands($filters = array()){
        $array = array();
        
        $where = $this->buildWhere($filters);
        
        $sql = "SELECT"
                . " id_brand,"
                . " COUNT(id) as c"
                . " FROM products"
                . " WHERE ".  implode(' AND ', $where)
                . " GROUP BY id_brand";
        $sql = $this->db->prepare($sql);
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
    
    
    
    private function buildWhere($filters){
        $where = array(
            '1=1'
        );
        
        
        if(!empty($filters['category'])){
            $where[] = "id_category=:id_category";
        }
        
        return $where;
    }
    
    
    
    private function bindWhere($filters, &$sql){
        if(!empty($filters['category'])){
           $sql->bindValue(":id_category", $filters['category']); 
        }
    }
}

