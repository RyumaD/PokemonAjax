<?php 
class EventRepository extends Repository {


    function getEvents(){
        $query = "SELECT * FROM event";
        $prep = $this->connection->query( $query );
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        if( empty( $result ) ){
            return false;
        }
        else {
            return $result;
        }
    }
    function saveEvent(Event $event){
        $query = "INSERT INTO event SET type=:type, debut=:debut, fin=:fin";
        $prep = $this->connection->prepare( $query );
        $prep->execute( [
            "type" => $event->getType(),
            "debut" => $event->getDebut(),
            "fin" => $event->getFin()
        ] );
        return $this->connection->lastInsertId();
    }
    
}