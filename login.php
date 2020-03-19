<?php
    session_start();
    if( loginDataIsSet()  )
    {
        $_SESSION["errores-login"] = [];
        if( $_POST["username"] == "" )
            array_push($_SESSION["errores-login"],"nombre de usuario esta vacio");
        if( $_POST["password"] == "")
            array_push($_SESSION["errores-login"],"contraseña esa vacio");
        if( count($_SESSION["errores-login"]) > 0 )
        {
            header("Location: ./index.php");
            die();
        }
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
                    header("Location: ./main.php");
                    die();
                }
                else
                {
                    array_push($_SESSION["errores-login"],"usuario y contraseña no concuerdan");
                    header("Location: ./index.php");
                    die();
                }
            }
        }
    }
    else
    {
        header("Location: ./index.php");
        die();
    }

    function loginDataIsSet()
    {
        return ( isset($_POST["username"]) && isset($_POST["password"]) ) ;
    }
?>