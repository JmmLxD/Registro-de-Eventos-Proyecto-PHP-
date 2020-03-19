<?php
    require_once "./database_connection.php";
    session_start();
    if( compraEventoDataIsSet()  )
    {
        if( isset($_SESSION["user-logged"]) )
        {
            $query = "insert into eventos_comprados
                      (nombre_evento,serial,username_comprador,fecha,ubicacion) 
                      values (:nombre_evento,:serial,:username_comprador, STR_TO_DATE(:fecha,'%Y-%m-%d') , :ubicacion)";
            $stmt = $con->prepare($query);
            if( $stmt->execute( [ "nombre_evento" => $_POST["nombre"]  , "serial" => $_POST["serial"] , "fecha" =>  $_POST["fecha"] ,
                                  "ubicacion" => $_POST["ubicacion"] , "username_comprador" =>  $_SESSION["user-data"]["username"] ] ) )
            {
                echo "YEEEEEEIIIIII";
            }
            else
            {
                echo "<br>" . $con->errorCode();
            }

        }
        else
            echo "A2";
    }
    else
        echo "A1";

    function compraEventoDataIsSet()
    {
        return ( !empty($_POST["nombre"]) && !empty($_POST["fecha"]) && !empty($_POST["ubicacion"]) && !empty($_POST["serial"])  )  ;
    }
?>

