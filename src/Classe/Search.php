<?php

namespace App\Classe;

class Search
{
     
    public $searchByName='';
   
    public $searchByCategory=[];

    public function __toString(){
        return $this->searchByName;
}

}