<?php 
    session_start();
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

        *
        {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        .msg
        {
            margin: 0 auto;
            width: 80%;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: grey;
            color: white;
        }

        .msg p
        {
            margin: 0.3rem 0;
        }

        form
        {
            border: solid 1px grey;
            padding: 1rem;
        }    
    </style>

</head>
<body>
    <h1> Registro de Eventos Wow </h1>

    <?php 
        if(!empty($_SESSION["errores-registro"]) )
        {
            echo "<div class='msg'>";

            for($i = 0 ; $i < count($_SESSION["errores-registro"]) ; $i++)
            {
                echo "<p>" .  $_SESSION["errores-registro"][$i] . "</p>";
            }

            echo "</div>";
        }
    
    ?>


    <form id="register-form" action="./registro.php" method="POST">
        <h2> log in </h2>
        
        <div>
            <label for="nombre-input-register"> Nombre </label>
            <input type="text" name="nombre"   id="nombre-input-register">
        </div>
        <div>
            <label for="apellido-input-register"> Apellido </label>
            <input type="text" name="apellido" id="apellido-input-register">
        </div>
        <div>
            <label for="cedula-input-register"> Cedula </label>
            <input type="text" name="cedula"   id="cedula-input-register">
        </div>
        <div>
            <label for="username-input-register"> Nombre de usuario </label>
            <input type="text" name="username"   id="username-input-register">
        </div>
        <div>
            <label for="password-input-register"> contraña </label>
            <input type="password" name="password"   id="password-input-register">
        </div>
        <div>
            <label for="telefono-input-register"> numero de telefono </label>
            <input type="text" name="telefono"   id="telefono-input-register">
        </div>
        <div>
            <label for="email-input-register"> email </label>
            <input type="email" name="email"   id="email-input-register">
        </div>
        <div>
            <label for="direccion-input-register"> direccion </label>
            <input type="text" name="direccion"   id="direccion-input-register">
        </div>
        <div>
            <input type="radio" id="sexo-hombre-radio-register" name="sexo" value="hombre" checked>
            <label for="sexo-hombre-radio-register"> hombre </label>
            <input type="radio" id="sexo-mujer-radio-register" name="sexo" value="mujer" checked>
            <label for="sexo-mujer-radio-register"> mujer </label>
        </div>

        <button type="submit"> Entrar </button>
    </form>
    
    <?php 
        if(!empty($_SESSION["errores-login"]) )
        {
            echo "<div class='msg'>";

            for($i = 0 ; $i < count($_SESSION["errores-login"]) ; $i++)
            {
                echo "<p>" .  $_SESSION["errores-login"][$i] . "</p>";
            }

            echo "</div>";
        }
    
    ?>

    <form id="login-form" action="./login.php" method="POST">
        <h2> log in </h2>
        
        <div>
            <label for="username-input-login"> Nombre de usuario </label>
            <input type="text" name="username"   id="username-input-login">
        </div>


        <div>
            <label for="password-input-login"> contraña </label>
            <input type="password" name="password"   id="password-input-login">
        </div>


        <button type="submit"> Entrar </button>
    </form>

</body>
</html> 