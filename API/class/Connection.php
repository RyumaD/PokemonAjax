<?php 
class Connection {

    static $connection = null;

    static function getConnection(){
      
        if( empty( self::$connection ) ){    
                self::$connection= new PDO( "mysql:host=localhost;dbname=pokemonGo", "root", "root");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$connection;
    }

    private function __construct(){}

}