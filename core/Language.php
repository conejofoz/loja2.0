<?php

class Language{
    
    private $l;
    private $ini;
    public function __construct() {
        global $config;
        /*----------  Define a linguagem padrão ingles  ----------*/
        $this->l = $config['default_lang'];
        
        /*----------  Se o usuário escolheu uma linguagem  ----------*/
        if(!empty($_SESSION['lang']) && file_exists('lang/'.$_SESSION['lang'].'.ini')){
            $this->l = $_SESSION['lang'];
        }
        
        /*----------  carregar arquivo ini e transformar em array  ----------*/
        $this->ini = parse_ini_file('lang/'.$this->l.'.ini');
    }
    
    
    
    /*=============================================
    =            funcão que irá fazer a tradução  =
    =============================================*/
    public function get($word, $return = false){
        $text = $word;
        
        if(isset($this->ini[$word])){
            $text = $this->ini['$word'];
        }
        
        /*----------  verifica o tipo de retorno - se vai ser return ou echo  ----------*/
        if($return){
            return $text;
        } else {
            echo $text;
        }
        
    }
    
    
    
    
}

