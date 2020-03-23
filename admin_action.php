<?php 
    session_start();
    if( !isset( $_SESSION["user-logged"]) || !$_SESSION["user-data"]["admin"] )
    {
        echo json_encode([ "status" => "unauthorized" ]);
        die();
    }
    if(!isset($_POST["action"]))
    {
        echo json_encode([ "status" => "error-no-action-specified" ]);
        die();
    }
    $action = $_POST["action"];
    if( $action ==  "get-eventos")
    {
        require_once "./database_connection.php";

        $query = "SELECT * FROM  eventos_comprados AS e
                    INNER JOIN usuarios AS u ON e.username_comprador = u.username";
        $stmt;
        if(!empty($_POST["serial"]))
        {
            $query .= " where e.serial = :serial";
            $stmt =  $con->prepare($query);
            $stmt->execute( ["serial" => $_POST["serial"]] );
        }
        else
        {
            $stmt =  $con->query($query);
        }



        $response["status"] = "ok";
        $response["eventos"] = [];
        while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
        {
            array_push($response["eventos"],$row);
        }        
        echo json_encode($response);
    }
    else if( $action ==  "delete-evento"  )
    {
        require_once "./database_connection.php";
        $query = "delete from eventos_comprados where serial = :serial";
        $stmt =  $con->prepare($query);
    
        if( !isset($_POST["serial"]) )
        {
            echo json_encode([ "status" => "error-no-serial-specified" ]);
            die();
        }
        else if( $stmt->execute([ "serial" =>  $_POST["serial"] ]) )
        {
            echo json_encode([ "status" => "ok"]);
            die();
        }
        else 
        {
            echo json_encode([ "status" => "internal-server-error" ]);
            die();
        }
    }
    else if( $action ==  "edit-evento"  )
    {
        require_once "./database_connection.php";
        $query = "  UPDATE eventos_comprados
                    SET serial = :newSerial, username_comprador = :username_comprador , nombre_evento = :nombre ,
                        fecha = STR_TO_DATE(:fecha,'%Y-%m-%d') , ubicacion = :ubicacion 
                    WHERE serial = :serial";
        $stmt =  $con->prepare($query);
    
        if( empty($_POST["new-serial"]) || empty($_POST["username-comprador"]) || empty($_POST["nombre"]) 
            || empty($_POST["fecha"])  || empty($_POST["ubicacion"]) || empty($_POST["serial"])  )
        {
            echo json_encode([ "status" => "error-all-data-specified" ]);
            die();
        }
        else if( $stmt->execute([ "serial" =>  $_POST["serial"] ,  "newSerial" => $_POST["new-serial"] , "username_comprador" => $_POST["username-comprador"] ,
                                  "nombre" =>  $_POST["nombre"] , "fecha" => $_POST["fecha"] , "ubicacion" => $_POST["ubicacion"] ]) )
        {
            echo json_encode([ "status" => "ok"]);
            die();
        }
        else 
        {
            echo json_encode([ "status" => "internal-server-error " . $con->errorCode()  . " " . $_POST["serial"] ]);
            die();
        }
    }
    else
    {
        echo json_encode([ "status" => "invalid action" ]);
        die();
    }
?>