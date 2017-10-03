<?php 
class UserRepository extends Repository {

    function getUserByUsername( User $user ){

        $query = "SELECT * FROM user WHERE username=:username";
        $prep = $this->connection->prepare( $query );
        $prep->execute([
            "username" => $user->getUsername()
        ]);
        $result = $prep->fetch(PDO::FETCH_ASSOC);

        if( empty( $result ) ){
            return false;
        }
        else {
            return $result;
        }
        
    }

    function save( User $user ){
        $flag = $this->getUserByUsername($user);
        
        if(empty($flag)){
            return $this->signin( $user );
        }
    }

    private function signin( User $user ){

        $query = "INSERT INTO user SET username=:username, password=:password";
        $prep = $this->connection->prepare( $query );
        $prep->execute( [
            "username" => $user->getUsername(),
            "password" => $user->getPassword()
        ] );
        return $this->connection->lastInsertId();

    }
    
    function login( User $user ){
        $query = "SELECT * FROM user WHERE username=:username AND password=:password";
        $prep = $this->connection->prepare( $query );
        $prep->execute([
            "username" => $user->getUsername(),
            "password" => $user->getPassword()
        ]);
        $result = $prep->fetch(PDO::FETCH_ASSOC);
        if( empty( $result ) ){
            return false;
        }
        else{
            return $result;
        }
    }
    function getUserIdByName($user){
        $query = "SELECT id FROM user WHERE username=:username";
        $prep = $this->connection->prepare( $query );
        $prep->execute([
            "username" => $user
        ]);
        $result = $prep->fetch(PDO::FETCH_ASSOC);
        if( empty( $result ) ){
            return false;
        }
        else{
            return $result["id"];
        }
    }
}