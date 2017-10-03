<?php

header("Access-Control-Allow-Origin:*",false);
require "flight/Flight.php"; 
require "autoload.php";

Flight::set("BddManager", new BddManager());

Flight::route("GET /pokemons/@username", function($username){
    $bddManager = Flight::get("BddManager");
    $repouse = $bddManager->getUserRepository();
    $userid = $repouse->getUserIdByName($username);
    if($userid != false){
        $pokemon = new pokemon();
        $pokemon->setUserId( $userid );

        $repo = $bddManager->getPokemonRepository();
        $pokemons = $repo->getAllByUserId($pokemon);
    }
    echo json_encode ( $pokemons );

});

Flight::route("GET /pokemon/@id", function( $id ){
    
    $status = [
        "success" => false,
        "pokemon" => false
    ];

    $pokemon = new pokemon();
    $pokemon->setId( $id );

    $bddManager = Flight::get("BddManager");
    $repo = $bddManager->getPokemonRepository();
    $pokemon = $repo->getById( $pokemon );

    if( $pokemon != false ){
        $status["success"] = true;
        $status["pokemon"] = $pokemon;
    }

    echo json_encode( $status );

});

Flight::route("POST /pokemon", function(){

    $pokename = Flight::request()->data["pokename"];
    $username = Flight::request()->data["username"];
    $bddManager = Flight::get("BddManager");
    $repoke = $bddManager->getPokemonRepository();
    $pokemonid = $repoke->getIdPokemon($pokename);
    $repouse = $bddManager->getUserRepository();
    $userid = $repouse->getUserIdByName($username);

    $status = [
        "success" => false,
        "id" => 0
    ];

    if( strlen( $pokename ) > 0) {
        $pokemon = new pokemon();
        $pokemon->setPokename( $pokename );
        $pokemon->setPokemonId( $pokemonid );
        $pokemon->setUserId( $userid );
        
        $id = $repoke->save( $pokemon );

        if( $id != 0 ){
            $status["success"] = true;
            $status["id"] = $id;
        }

    }

    echo json_encode( $status ); 
    
});

Flight::route("DELETE /pokemon/@id", function( $id ){

    $status = [
        "success" => false
    ];

    $pokemon = new pokemon();
    $pokemon->setId( $id );

    $bddManager = Flight::get("BddManager");
    $repo = $bddManager->getpokemonRepository();
    $rowCount = $repo->delete( $pokemon );

    if( $rowCount == 1 ){
        $status["success"] = true;
    }

    echo json_encode( $status );
    
});
Flight::route("POST /login", function(){
    
        $username = Flight::request()->data["username"];
        $password = Flight::request()->data["password"];
    
        $status = [
            "success" => false,
            "id" => 0
        ];
    
        if( strlen( $username ) > 0 && strlen( $password ) > 0 ) {
    
            $user = new User();
            $user->setUsername( $username );
            $user->setPassword( $password );
            $bddManager = Flight::get("BddManager");
            $repo = $bddManager->getUserRepository();
            $id = $repo->login( $user );
    
            if( $id != 0 ){
                $status["success"] = true;
                $status["id"] = $id;
            }
    
        }
    
        echo json_encode( $status ); 
        
    });
Flight::route("POST /signin", function(){

    $username = Flight::request()->data["username"];
    $password = Flight::request()->data["password"];

    $status = [
        "success" => false,
        "id" => 0
    ];

    if( strlen( $username ) > 0 && strlen( $password ) > 0 ) {

        $user = new User();
        $user->setUsername( $username );
        $user->setPassword( $password );
        $bddManager = Flight::get("BddManager");
        $repo = $bddManager->getUserRepository();
        $id = $repo->save( $user );

        if( $id != 0 ){
            $status["success"] = true;
            $status["id"] = $id;
        }

    }

    echo json_encode( $status ); 
    
});

Flight::route("POST /event", function(){

    $type = Flight::request()->data["type"];
    $debut = Flight::request()->data["debut"];
    $fin = Flight::request()->data["fin"];

    $status = [
        "success" => false,
        "id" => 0
    ];

    $event = new Event();
    $event->setType( $type );
    $event->setDebut( $debut );
    $event->setFin( $fin );
    $bddManager = Flight::get("BddManager");
    $repo = $bddManager->getEventRepository();
    $id = $repo->saveEvent( $event );

    if( $id != 0 ){
        $status["success"] = true;
        $status["id"] = $id;
    }
    echo json_encode( $status ); 
});

Flight::route("GET /events", function(){
    $bddManager = Flight::get("BddManager");
    $repoeve = $bddManager->getEventRepository();
    $events = $repoeve->getEvents();
    echo json_encode ( $events );

});

Flight::route("POST /pokedex", function(){
    header("Content-type:application/json");
    $bddManager = Flight::get("BddManager");
    $repoke = $bddManager->getPokemonRepository();
    $pokedex = $repoke->getPokedex();
    foreach ($pokedex as $pokemon) {
        
    }
    echo json_encode ([
        "attachments"=> [
                "title"=> $pokedex['pokemonid'],
                "text"=> $pokedex['pokename'],
        ]
    ]);
});

Flight::start();