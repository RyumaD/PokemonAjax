<?php
class Event extends Model implements JsonSerializable {

    private $type;
    private $debut;
    private $fin;


    function getType(){
        return $this->type;
    }

    function getDebut(){
        return $this->debut;
    }

    function getFin(){
        return $this->fin;
    }

    function setType( $type ){
        $this->type = $type;
    }

    function setDebut( $debut ){
        $this->debut = $debut;
    }

    function setFin($fin){
        $this->fin = $fin;
    }

    function jsonSerialize(){
        return [
            "id" => $this->id,
            "type" => $this->type,
            "debut" => $this->debut,
            "fin" => $this->fin
        ];
    }

}