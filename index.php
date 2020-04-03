<?php 
    session_start();



    $loginData = [
        "username" => (isset($_SESSION["login-data"]["username"])  ? $_SESSION["login-data"]["username"] : "" ) ,
        "password" => (isset($_SESSION["login-data"]["password"]) ? $_SESSION["login-data"]["password"] : "" ) 
    ];


    $registerData = [
        "username" => (isset($_SESSION["register-data"]["username"])  ? $_SESSION["register-data"]["username"] : "" ) ,
        "password" => (isset($_SESSION["register-data"]["password"]) ? $_SESSION["register-data"]["password"] : "" ) ,
        "nombre" =>   (isset($_SESSION["register-data"]["nombre"])  ? $_SESSION["register-data"]["nombre"] : "" ) ,
        "apellido" => (isset($_SESSION["register-data"]["apellido"]) ? $_SESSION["register-data"]["apellido"] : "" ) ,
        "email" => (isset($_SESSION["register-data"]["email"])  ? $_SESSION["register-data"]["email"] : "" ) ,
        "direccion" => (isset($_SESSION["register-data"]["direccion"]) ? $_SESSION["register-data"]["direccion"] : "" ) ,
        "telefono" => (isset($_SESSION["register-data"]["telefono"])  ? $_SESSION["register-data"]["telefono"] : "" ) ,
        "cedula" => (isset($_SESSION["register-data"]["cedula"])  ? $_SESSION["register-data"]["cedula"] : "" ) 
    ]

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Eventos </title>

    <style>

        body , html 
        {
            margin:0;
            padding: 2rem;
            background-color: #fbfbfb;
        }

        main form
        {
            background-color: white;
        }

        *
        {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }


        #register-section , #login-section 
        {
            width: 40%;
        }

        form
        {
            width: 100%;
            border: solid 1px grey;
            padding: 1.5rem;

        }    

        form p 
        {
            margin: 0;
            font-size: 1.2rem;
        }

        form > div 
        {
            display: flex;
            flex-direction: column;
            margin: 1rem 0;
        }

        form > div label , form > div input
        {
            font-size:1.2rem;
        }

        form > div input
        {
            padding: 0.2rem;
            border-radius: 0.3rem;
            border: 1px solid grey;
        }


        main
        {
            width: 90%;
            margin: 0 auto 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        #login-form 
        {
            align-self: start;
        }

        button 
        {
            display: block;
            margin: 0.8rem auto 0;
            font-size: 1.2rem;
            color : rgb(29, 29, 29);
            background-color: #FFCC00;
            border: solid 1px  #EEBB00 ;
            border-radius: 0.4rem;
            padding: 0.2rem 0.6rem;
        }

        .bad-msg
        {
            color: #2e2e2e;
            background-color: #ffb5b0;
            border: solid 1px #ba2532;
            border-radius: 1rem;
            padding: 0.5rem 1rem;
            margin-bottom: 2rem;
        }

        .bad-msg header
        {
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            align-items: center;
            border-bottom: solid 1px #ba2532;
        }

        .bad-msg header img 
        {
            width: 2rem;
            margin-bottom: 0.2rem;
        }

        .bad-msg header p 
        {
            
            margin:0;
            font-size : 1.3rem;
        }

        .msg 
        {
            margin: 0;
            
            font-size: 1.2rem;
            padding: 0.5rem 0;
            text-align: center;
        }

    </style>

</head>
<body>

    <main>
        <div id="register-section">

                <?php if( !empty($_SESSION["register-error-msg"]) ) { ?>
                    <div class="bad-msg">
                        <header>
                            <p> ALGO FUE MAL </p>
                            <img src="error.svg" alt="imagen de error">
                        </header>

                        <p class="msg"> <?php echo $_SESSION["register-error-msg"];  ?> </p>
                    </div>
                <?php } ?>

            <form id="register-form" action="./registro.php" method="POST">
                <h2> Crear Usuario Nuevo </h2>
                
                <div>
                    <label for="nombre-input-register"> Nombre </label>
                    <input type="text" name="nombre" value="<?php echo $registerData["nombre"]; ?>"   id="nombre-input-register">
                </div>
                <div>
                    <label for="apellido-input-register"> Apellido </label>
                    <input type="text" name="apellido" value="<?php echo $registerData["apellido"]; ?>"   id="apellido-input-register">
                </div>
                <div>
                    <label for="cedula-input-register"> Cedula </label>
                    <input type="number" name="cedula" value="<?php echo $registerData["cedula"]; ?>"    id="cedula-input-register">
                </div>
                <div>
                    <label for="username-input-register"> Nombre de usuario </label>
                    <input type="text" name="username" value="<?php echo $registerData["username"]; ?>"    id="username-input-register">
                </div>
                <div>
                    <label for="password-input-register"> Contraña </label>
                    <input type="password" name="password" value="<?php echo $registerData["password"]; ?>"     id="password-input-register">
                </div>
                <div>
                    <label for="telefono-input-register"> Numero de Telefono </label>
                    <input type="text" name="telefono"  value="<?php echo $registerData["telefono"]; ?>"    id="telefono-input-register">
                </div>
                <div>
                    <label for="email-input-register"> Email </label>
                    <input type="email" name="email" value="<?php echo $registerData["email"]; ?>"   id="email-input-register">
                </div>
                <div>
                    <label for="direccion-input-register"> Direccion </label>
                    <input type="text" name="direccion"  value="<?php echo $registerData["direccion"]; ?>"   id="direccion-input-register">
                </div>
                <div>
                    <p> Sexo :   </p>
                    <div>
                        <input type="radio" id="sexo-hombre-radio-register" name="sexo" value="hombre" checked>
                        <label for="sexo-hombre-radio-register"> hombre </label>
                        <input type="radio" id="sexo-mujer-radio-register" name="sexo" value="mujer" checked>
                        <label for="sexo-mujer-radio-register"> mujer </label>
                    </div>


                </div>

                <button type="submit"> Crear Usuario </button>
            </form>
        </div> 

        
        <div id="login-section">


        
            <?php if( !empty($_SESSION["login-error-msg"]) ) { ?>
                <div class="bad-msg">
                    <header>
                        <p> ALGO FUE MAL </p>
                        <img src="error.svg" alt="imagen de error">
                    </header>

                    <p class="msg"> <?php echo $_SESSION["login-error-msg"];  ?> </p>
                </div>
            <?php } ?>


            <form id="login-form" action="./login.php" method="POST">
                <h2>  Ingresar Cuenta  </h2>
                
                <div>
                    <label for="username-input-login"> Nombre de usuario </label>
                    <input type="text" name="username" 
                    value="<?php echo $loginData["username"]  ?>"   
                    id="username-input-login">
                </div>

                <div>
                    <label for="password-input-login"> Contraña </label>
                    <input type="password" name="password"
                    value="<?php echo $loginData["password"]  ?>"   
                    id="password-input-login">
                </div>

                <button type="submit"> Ingresar </button>
            </form>
        </div>


    </main>
</body>
</html> 

<?php
    unset($_SESSION["login-data"]);
    unset($_SESSION["login-error-msg"]);
    unset($_SESSION["register-error-msg"]);
    unset($_SESSION["register-data"]);
?>