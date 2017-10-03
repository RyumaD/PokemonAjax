<?php 
class PokemonRepository extends Repository {

    function getAllByUserId( Pokemon $pokemon ){
        $query = "SELECT * FROM pokemon WHERE userid=:userid";
        $result = $this->connection->prepare( $query );
        $result->execute([
            "userid" => $pokemon->getUserId()
        ]);
        $result = $result->fetchAll( PDO::FETCH_ASSOC );
        return $result;
        $pokemons = [];
        foreach( $result as $data ){
            $pokemons[] = new Pokemon( $data );
        }

        return $pokemons;  
    }

    function getById( Pokemon $pokemon ){

        $query = "SELECT * FROM pokemon WHERE id=:id";
        $prep = $this->connection->prepare( $query );
        $prep->execute([
            "id" => $pokemon->getId()
        ]);
        $result = $prep->fetch(PDO::FETCH_ASSOC);

        if( empty( $result ) ){
            return false;
        }
        else {
            return new Pokemon( $result );
        }
        
    }

    function save( Pokemon $pokemon ){
        if( empty( $pokemon->getId() ) ){
            return $this->insert( $pokemon );
        }
    }

    private function insert( Pokemon $pokemon ){

        $query = "INSERT INTO pokemon SET pokename=:pokename, pokemonid=:pokemonid, userid=:userid";
        $prep = $this->connection->prepare( $query );
        $prep->execute( [
            "pokename" => $pokemon->getPokename(),
            "pokemonid" => $pokemon->getPokemonId(),
            "userid" => $pokemon->getUserId()
        ] );
        return $this->connection->lastInsertId();

    }

    function delete( Pokemon $pokemon ) {

        $query = "DELETE FROM pokemon WHERE id=:id";
        $prep = $this->connection->prepare( $query );
        $prep->execute([
            "id" => $pokemon->getId()
        ]);
        return $prep->rowCount();

    }

    function getIdPokemon($name){
        $query = "SELECT * FROM pokedex WHERE pokename=:pokename";

        $result = $this->connection->prepare( $query );
        $result->execute([
            "pokename" => $name
        ]);

        $result = $result->fetch( PDO::FETCH_ASSOC );

        return $result["id"];
    }
    function getPokedex(){
        $query = "SELECT pokemonid,pokename FROM pokemon WHERE userid=:userid";
        
                $result = $this->connection->prepare( $query );
                $result->execute([
                    "userid" => "1"
                ]);
        
                $result = $result->fetchAll( PDO::FETCH_ASSOC );
        
                return $result;
    }
}