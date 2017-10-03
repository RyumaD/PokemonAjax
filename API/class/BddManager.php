<?php 
class BddManager {

    private $pokemonRepository;
    private $userRepository;
    private $eventRepository;
    private $connection;

    function __construct(){
        $this->connection = Connection::getConnection();
        $this->eventRepository = new EventRepository( $this->connection );
        $this->pokemonRepository = new PokemonRepository( $this->connection );
        $this->userRepository = new UserRepository( $this->connection );
    }

    function getPokemonRepository(){
        return $this->pokemonRepository;
    }

    function getUserRepository(){
        return $this->userRepository;
    }

    function getEventRepository(){
        return $this->eventRepository;
    }

}