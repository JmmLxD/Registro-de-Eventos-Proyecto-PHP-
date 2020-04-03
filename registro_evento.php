<?php
    require_once "./database_connection.php";
    session_start();
    $error = true;


    if( compraEventoDataIsSet()  )
    {
        if( isset($_SESSION["user-logged"]) )
        {
            $query = "insert into boletos_registrados
                      (evento,serial,username_comprador,fecha,ubicacion) 
                      values (:evento,:serial,:username_comprador, STR_TO_DATE(:fecha,'%Y-%m-%d') , :ubicacion)";
            $stmt = $con->prepare($query);
            $data = [ "evento" => $_POST["evento"]  , "serial" => $_POST["serial"] , 
                             "fecha" =>  $_POST["fecha"]   , "ubicacion" => $_POST["ubicacion"] ,
                             "username_comprador" =>  $_SESSION["user-data"]["username"] ];

            

            

            if( !$stmt->execute( $data ) )
            {
                echo "A1";
                die();
            }
            else
            {
                $query = "select nombre from eventos where id = :id";
                $stmt = $con->prepare($query);
                $stmt->execute( [ "id" => $_POST["evento"]  ] );
                $data["evento"] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["nombre"];

            }
        }
        else
        {
            echo "A2";
            die();
        }
    }
    else
    {
        echo "A3";
        die();
    }

    function compraEventoDataIsSet()
    {
        return ( !empty($_POST["evento"]) && !empty($_POST["fecha"]) && !empty($_POST["ubicacion"]) && !empty($_POST["serial"])  )  ;
    }
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registro Boleto </title>

        <style>

            body , html 
            {
                font-family: Arial, Helvetica, sans-serif;
                margin:0;
                padding:0;
            }

            main
            {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 35rem;
                max-width: 95%;
                margin: 3rem auto 0;
                padding: 1rem;
            }

            h1
            {
                width: 100%;
                padding: 0.5rem;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                color: rgb(68, 95, 6);
                border-bottom: 1px solid rgb(68, 95, 6);
                margin: 0;
            }

            ul 
            {
                width: 100%;
                margin: 0;
                list-style: none;
                
                padding: 0 2rem;
            }

            ul li
            {
                display: flex;
                padding: 1rem;
                border-bottom: 1px solid rgb(68, 95, 6);
                justify-content: space-between;
                align-items: center;
                flex-direction: row;
            }

            h1 img
            {
                width: 2.5rem;
            }

            .volver-btn
            {
                margin-top: 1rem;
                color: #fafafa;
                font-size: 1.2rem;
                border-radius: 0.5rem;
                padding: 0.4rem 1.2rem;
                background-color: #3BB54A;
                text-decoration: none;
                border: solid 2px rgb(68, 95, 6) ;
            }

        
        </style>

    </head>
    <body>
        <main>
                <h1> <span>Registro Exitoso</span>  <img src="exito.svg" alt="registro exitoso" > </h1>
                <ul>
                    <li> <span>nombre del evento:</span> <span>  <?php echo $data["evento"] ?> </span> </li>
                    <li> <span>comprador del boleto (username):</span> <span>  <?php echo $data["username_comprador"] ?> </span> </li>
                    <li> <span>serial del boleto:</span> <span>  <?php echo $data["serial"] ?> </span> </li>
                    <li> <span>ubicacion:</span> <span>  <?php echo $data["ubicacion"] ?> </span> </li>
                    <li> <span>fecha:</span> <span>  <?php echo $data["fecha"] ?> </span> </li>
                </ul>
                <a href="main.php" class="volver-btn"> Volver al Registro </a> 
        </main>
    </body>
</html>