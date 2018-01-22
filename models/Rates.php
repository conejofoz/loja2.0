<?php

/**
 * Rates [ TIPO ]
 *
 * @author geral
 * Descricao
 * @copyright (c) year, Silvio Coelho 
 */
class Rates extends Model {
    
    public function getRates($id, $qt){
        $array = array();
        $sql = "SELECT"
                . " *,"
                . " (select users.name from users where users.id = rates.id_user) as user_name"
                . " FROM rates"
                . " WHERE id_product = :id "
                . " ORDER BY date_rated DESC"
                . " LIMIT ".$qt;
        //echo $sql;exit;
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        //var_dump($array);exit;
        return $array;
    }
}
