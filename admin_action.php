<?php 
    try
    {
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
    
            $query = "SELECT * , u.nombre as nombre_comprador , e.nombre as nombre_evento 
                        FROM  boletos_registrados AS b
                            INNER JOIN usuarios AS u ON b.username_comprador = u.username
                            INNER JOIN eventos AS e ON b.evento = e.id";
            $stmt;
            if(!empty($_POST["serial"]))
            {
                $query .= " where serial = :serial";
                $stmt =  $con->prepare($query);
                $stmt->execute( ["serial" => $_POST["serial"] ] );
            }
            else
            {
                $stmt =  $con->query($query);
            }

            $response["status"] = "ok" ;
            $response["eventos"] = [];
            while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
            {
                array_push($response["eventos"],$row);
            }        
            echo json_encode($response);
        }
        else if( $action == "crear-evento" )
        {
            if( !empty( $_POST["nombre"] ) && !empty( $_POST["descripcion"] ) && !empty( $_POST["entradas-altos"] ) && !empty( $_POST["entradas-medios"] ) &&
                !empty( $_POST["entradas-vip"] ) && !empty( $_POST["entradas-platino"] ) )
            {
                
                require_once "./database_connection.php";
                $query = "INSERT INTO eventos (nombre,descripcion,entradas_altos,entradas_medios,entradas_vip,entradas_platino)
                         VALUES (:nombre,:descripcion,:altos,:medios,:vip,:platino);";
                $stmt = $con->prepare($query);

                if( $stmt->execute( [ "nombre" => $_POST["nombre"] , "descripcion" => $_POST["descripcion"] , "altos" => $_POST["entradas-altos"] 
                    , "medios" => $_POST["entradas-medios"]  , "vip" => $_POST["entradas-vip"] ,  "platino" => $_POST["entradas-vip"] ] ))
                {
                    echo json_encode([ "status" => "ok"  ]);
                    die();                    
                }
                else
                {
                    echo json_encode([ "status" => "internal-server-error " . $con->errorCode() ]);
                    die();
                }
            }
            else
            {
                echo json_encode([ "status" => "error-data-missing"  ]);
                die();
            }


        }   
        else if( $action ==  "delete-evento"  )
        {
            require_once "./database_connection.php";
            $query = "delete from boletos_registrados where serial = :serial";
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
                echo json_encode([ "status" => "internal-server-error " . $con->errorCode() ]);
                die();
            }
        }
        else if( $action ==  "username-list"  )
        {
            require_once "./database_connection.php";
            $query = "select username  from usuarios ";
            $stmt =  $con->query("select username from usuarios");
    
    
    
            $usernames = [];
    
            foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row  )
                array_push($usernames,$row["username"]);
    
            $response = [];
            $response["status"] = "ok";
            $response["usernames"] = $usernames;
            echo json_encode($response);
            die();
        }
        else if ( $action == "eventos-list")
        {
            require_once "./database_connection.php";
            $query = "select  nombre , id  from eventos";
            $stmt =  $con->query($query);
            $eventos = [];
            foreach( $stmt->fetchAll(PDO::FETCH_ASSOC) as $row  )
                array_push($eventos,$row);
    
            $response = [];
            $response["status"] = "ok";
            $response["eventos"] = $eventos;
            echo json_encode($response);
            die();
        }
        else if( $action ==  "edit-evento"  )
        {
            require_once "./database_connection.php";
            $query = "  UPDATE boletos_registrados
                        SET serial = :newSerial, username_comprador = :username_comprador , evento = :evento ,
                            fecha = STR_TO_DATE(:fecha,'%Y-%m-%d') , ubicacion = :ubicacion 
                        WHERE serial = :serial";
            $stmt =  $con->prepare($query);


            if( empty($_POST["new-serial"]) || empty($_POST["username-comprador"]) || empty($_POST["evento"]) 
                || empty($_POST["fecha"])  || empty($_POST["ubicacion"]) || empty($_POST["serial"])  )
            {
                echo json_encode([ "status" => "error-data-missing" ]);
                die();
            }
            else if( $stmt->execute([ "serial" =>  $_POST["serial"] ,  "newSerial" => $_POST["new-serial"] , "username_comprador" => $_POST["username-comprador"] ,
                                      "evento" =>  $_POST["evento"] , "fecha" => $_POST["fecha"] , "ubicacion" => $_POST["ubicacion"] ]) )
            {
                $response = [];

                $query = "SELECT * , u.nombre as nombre_comprador , e.nombre as nombre_evento FROM  boletos_registrados AS b
                        INNER JOIN usuarios AS u ON b.username_comprador = u.username
                        INNER JOIN eventos as e on e.id = b.evento
                        WHERE b.serial = :serial";
    
                $stmt = $con->prepare($query);
    
                if($stmt->execute(["serial" => $_POST["new-serial"]]))
                {
                    $newData = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                    $response["status"] = "ok";
                    $response["newData"] = $newData;
                    echo json_encode($response);
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
                echo json_encode([ "status" => "internal-server-error " . $con->errorCode()  . " " . $_POST["serial"] ]);
                die();
            }
        }
        else
        {
            echo json_encode([ "status" => "invalid action" ]);
            die();
        }
    }
    catch( Exception $e )
    {
        echo json_encode([ "status" => "internal-server-error , exeption : " . $e->getMessage() . " " . $_POST["serial"] ]);
        die();
    }


    
?>