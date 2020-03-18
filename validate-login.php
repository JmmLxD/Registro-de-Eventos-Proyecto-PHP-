<?php 
    session_start();
    if( loginDataIsSet()  )
    {
        $userData = [];
        $userData["username"] = $_POST["username"];
        $userData["nombre"]   = "chemiguel";
        $userData["apellido"] = "togami";
        $userData["telefono"] = "0414-709-2291";
        $_SESSION["user-logged"] = true;
        $_SESSION["user-data"] = $userData;
        header("Location: ./main.php");
        die();

    }
    else
        echo "AAAAAAAAAAAAAAAAAAAAAAAA";

    function loginDataIsSet()
    {
        return ( isset($_POST["username"]) && isset($_POST["password"]) ) ;
    }
?>