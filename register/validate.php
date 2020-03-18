<?php 
    session_start();
    if(registerDataIsSet())
    {
        $registerData = [];
        $registerData["username"] = $_POST["username"];
        $registerData["nombre"]   = $_POST["nombre"];
        $registerData["apellido"] = $_POST["apellido"];
        $registerData["cedula"]   = $_POST["cedula"];
        $registerData["password"] = $_POST["password"];
        $registerData["telefono"] = $_POST["telefono"];
        $registerData["email"]    = $_POST["email"];
        $registerData["sexo"]     = $_POST["sexo"];
        $_SESSION["register-made"] = true;
        $_SESSION["register-data"]    = $registerData;
     
        header("Location: ./success.php");
        die();
    }
    else
        echo "AAAAAAAAAAAAAAAAAAAAAAAA fuck men :(";

    function registerDataIsSet()
    {
        return  ( isset($_POST["username"]) && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["cedula"]) &&
                  isset($_POST["password"]) && isset($_POST["telefono"]) && isset($_POST["email"])  && isset($_POST["sexo"]));
    }
?>


