<?php
class Pokemon extends Model implements JsonSerializable {

    private $pokename;
    private $pokemonid;
    private $userid;

    function getPokename(){
        return $this->pokename;
    }

    function getPokemonId(){
        return $this->pokemonid;
    }

    function getUserId(){
        return $this->userid;
    }

    function setPokename( $pokename ){
        $this->pokename = $pokename;
    }

    function setPokemonId($pokemonid){
        $this->pokemonid = $pokemonid;
    }

    function setUserId($userid){
        $this->userid = $userid;
    }

    function jsonSerialize(){
        return [
            "id" => $this->id,
            "pokename" => $this->pokename,
            "pokemonid" => $this->pokemonid,
            "userid" => $this->userid
        ];
    }

}