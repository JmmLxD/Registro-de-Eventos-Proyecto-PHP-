<?php
    session_start();

    if(  isset( $_POST["username"] )  )
        $_SESSION["login-data"]["username"] = $_POST["username"];
    if( isset( $_POST["password"] ) )
    {
        $_SESSION["login-data"]["password"] = $_POST["password"];
    }

    if( loginDataIsSet()  )
    {
        if( $_POST["password"] == "" )
            $_SESSION["login-error-msg"] = "el campo contraseña esta vacio";
        else if( $_POST["username"] == "" )
            $_SESSION["login-error-msg"] = "el campo username esta vacio";
        else 
        {
            require_once "./database_connection.php";
            $stmt = $con->prepare("select * from usuarios where username = :username && password = :password");
            if(!$stmt->execute( [ "username" => $_POST["username"] , "password" => $_POST["password"] ] ) )
                array_push($_SESSION["errores-login"],"error interno del server , vuelva a intentar mas tarde");
            else
            {
                $arr =  $stmt->fetchAll( PDO::FETCH_ASSOC );
                if( count($arr) == 1)
                {
                    $usuario = $arr[0];
                    $_SESSION["user-logged"] = true;
                    $_SESSION["user-data"] = $usuario;
                    unset( $_SESSION["login-data"] );
                    header("Location: ./main.php");
                    die();
                }
                else
                    $_SESSION["login-error-msg"] = "la contraseña o el usuario estan erroneas";
            }
        }
    }

    header("Location: ./index.php");
    die();

    function loginDataIsSet()
    {
        return ( isset($_POST["username"]) && isset($_POST["password"]) ) ;
    }
?>