<?php
    session_start();
    require_once "./database_connection.php";

    $_SESSION["register-error-msg"] = "";

    if(  isset( $_POST["username"] )  )
        $_SESSION["register-data"]["username"] = $_POST["username"];
    if( isset( $_POST["password"] ) )
        $_SESSION["register-data"]["password"] = $_POST["password"];
    if( isset( $_POST["cedula"] ) )
        $_SESSION["register-data"]["cedula"] = $_POST["cedula"];
    if( isset( $_POST["email"] ) )
        $_SESSION["register-data"]["email"] = $_POST["email"];
    if( isset( $_POST["telefono"] ) )
        $_SESSION["register-data"]["telefono"] = $_POST["telefono"];
    if( isset( $_POST["direccion"] ) )
        $_SESSION["register-data"]["direccion"] = $_POST["direccion"];
    if( isset( $_POST["apellido"] ) )
        $_SESSION["register-data"]["apellido"] = $_POST["apellido"];
    if( isset( $_POST["nombre"] ) )
        $_SESSION["register-data"]["nombre"] = $_POST["nombre"];


    if( !registerDataIsSet() )
    {
        if( $_POST["nombre"] == "" )
            $_SESSION["register-error-msg"] = "el campo de nombre esta vacio";
        if( $_POST["username"] == "" )
            $_SESSION["register-error-msg"] = "el campo de username esta vacio";
        else
            {
                $query = "SELECT COUNT(*) AS c FROM usuarios WHERE username = :username";
                $stmt = $con->prepare($query);
                $stmt->execute(  [ "username" => $_POST["username"]  ] );
                $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["c"];
                if($count > 0)
                    $_SESSION["register-error-msg"] = "nombre de usuario ya existe";
            }
        if( $_POST["cedula"] == "" )
            $_SESSION["register-error-msg"] = "el campo de cedula esta vacio";
        if( $_POST["apellido"] == "" )
            $_SESSION["register-error-msg"] = "el campo de apellido esta vacio";
        if( $_POST["password"] == "" )
            $_SESSION["register-error-msg"] = "el campo de password esta vacio";
        if( $_POST["email"] == "" )
            $_SESSION["register-error-msg"] = "el campo de email esta vacio";
        if( $_POST["telefono"] == "" )
            $_SESSION["register-error-msg"] = "el campo de telefono esta vacio";
        if( $_POST["direccion"] == "" )
            $_SESSION["register-error-msg"] = "el campo de direccion esta vacio";
        

        if( isset($_SESSION["register-error-msg"]) && $_SESSION["register-error-msg"] == "" )
        {
            $query = "insert into usuarios 
            (username,password,nombre,apellido,cedula,telefono,email,sexo,direccion)
            values (:username,:password,:nombre,:apellido,:cedula,:telefono,:email,:sexo,:direccion)";
            $stmt = $con->prepare( $query );
            $_POST = [ "username" => $_POST["username"],  "nombre" => $_POST["nombre"],  "apellido" => $_POST["apellido"], 
                    "cedula" => $_POST["cedula"], "password" => $_POST["password"],  "telefono" => $_POST["telefono"], 
                    "email" => $_POST["email"],  "sexo" => $_POST["sexo"] , "direccion" => $_POST["direccion"] ];
            if(!$stmt->execute($_POST))
            {
                $_SESSION["register-error-msg"] = "ups error interno de server , vuelva a intentarlo mas tarde";
                header("Location: ./index.php");
                die();
            }
            else
            {
                unset($_SESSION["register-data"]);
            }
        }
        else
        {
            echo "sas";
            die();
            header("Location: ./index.php");
            die();
        }

    }
    else
    {
        header("Location: ./index.php");
        die();
    }
        function registerDataIsSet()
        {
            return  ( !isset($_POST["username"]) && !isset($_POST["nombre"]) && !isset($_POST["apellido"]) && !isset($_POST["cedula"]) &&
                      !isset($_POST["password"]) && !isset($_POST["telefono"]) && !isset($_POST["email"])  && !isset($_POST["sexo"])) 
                     && !isset($_POST["direccion"]);
        }
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Registro Exitoso </title>

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
                    <li> <span>nombre:</span> <span>  <?php echo $_POST["nombre"] ?> </span> </li>
                    <li> <span>apellido:</span> <span>  <?php echo $_POST["apellido"] ?> </span> </li>
                    <li> <span>username:</span> <span>  <?php echo $_POST["username"] ?> </span> </li>
                    <li> <span>direccion:</span> <span>  <?php echo $_POST["direccion"] ?> </span> </li>
                    <li> <span>cedula:</span> <span>  <?php echo $_POST["cedula"] ?> </span> </li>
                    <li> <span>sexo:</span> <span>  <?php echo $_POST["sexo"] ?> </span> </li>
                    <li> <span>telefono:</span> <span>  <?php echo $_POST["telefono"] ?> </span> </li>
                    <li> <span>email:</span> <span>  <?php echo $_POST["email"] ?> </span> </li>
                </ul>
                <a href="main.php" class="volver-btn"> Volver a la paguina principal </a> 
        </main>
    </body>
</html>