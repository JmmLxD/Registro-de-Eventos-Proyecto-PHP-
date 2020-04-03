<?php 
  session_start();
  if(isset($_POST["delete-all"]))
  {
      session_unset();
  }
  $userData = null;
  if( !isset($_SESSION["user-logged"]) )
  {
      header("Location: ./index.php");
      die();
  }
  else
      $userData = $_SESSION["user-data"];

  require_once "./database_connection.php";

  $stmt = $con->query("SELECT nombre,id from eventos;");

  $eventos = [];

  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
      array_push($eventos,$row);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>
        window.addEventListener("load",()=>{
            let form = document.querySelector("form");
            form.addEventListener("submit", async(ev)=>{
                console.log("mmm ");
                ev.preventDefault();
                let fd = new FormData(form);
                let data = {};
                fd.forEach( (value,key) => {
                        data[key] = value;
                });
                data["action"] = "crear-evento";
                let request = new Request("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                    body: new URLSearchParams(data).toString()
                });
                let response = await( (await  fetch(request)) .text() );
                if(response.status = "ok")
                    alert("NUEVO EVENTO AGREGADO EXISTOSAMENTE ,estoy cansado profe asi que no le puse empeño");
            });
        });
    </script>

    <style>

        *
        {
            box-sizing: border-box;
        }

        body > header
        {
            padding: 0 3rem;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #ffcc00;
        }   

        body , html 
        {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%
        }

        header h1
        {
            color: #222;
        }

        .btn-header
        {
            border-bottom: #222 solid 2px;
            display: inline-block;
            margin: 0 1rem;
            font-size: 1.2rem;

            color: #222;
            text-decoration: none;
        }
        .btn-header:visited
        {
            color: #222;
        }
        .btn-header:hover
        {
            color: #666;
        }

        main > h2
        {
            color: rgb(68, 95, 6);
            font-size: 1.2rem;
            margin: 0;
        }

        main
        {
            padding: 1rem;
            margin:  0 auto;
            margin-top: 2rem;
            border: 1px solid black;
        }

        @media (max-width: 1000px) 
        { 
            main
            {
                width: 93%;
            }
            .fields
            {
                width: 100% !important;
            }

            .form-image
            {  
                display: none;
            }
        }

        @media (min-width: 1000px) 
        { 
            main
            {
                width: 70%;
            }
        }



        .fields
        {
            display: flex;
            flex-direction: column;
        }    

        form
        {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .fields
        {
            width: 50%;
        }

        .form-image
        {
            margin: 0;
            width: 45%;
            background-image: url(evento.png);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            align-self: stretch;
        }

        
        form 
        {
            padding: 0 1rem;
            
        }

        form input , form select , form textarea
        {
            
            display: block;
            width: 95%;
            margin: 0.5rem 0rem;
        }    

        button 
        {
            margin-top: 0.8rem;
            font-size: 1.2rem;
            color : rgb(29, 29, 29);
            background-color: #FFCC00;
            border: solid 1px  #EEBB00 ;
            border-radius: 0.4rem;
            padding: 0.2rem 0.6rem;
        }

    
    </style>

</head>
<body>
    <header>
        <h1> Registro De Eventos </h1>
        <div id="acciones">
            <a class="btn-header" href="main.php"> Registrar Boleto </a>
            <?php if( $userData["admin"] ) { ?>
                <a class="btn-header" href="admin.php"> CRUD de Registros </a>
                
            <?php } ?>
            
            <a class="btn-header" href="cerrar_sesion.php"> Cerrar Sesión </a>
        </div>
    </header>

    <main>
        <h2> Agregar Nuevo Evento</h2>
        <p> inserte los datos del nuevo evento en el formulario </p>
        <form method="POST">
            <div class="fields">
                    <div>
                        <label for="nombre-input"> Nombre </label>
                        <input type="text" name="nombre"  id="nombre-input">
                    </div>
                    <div>
                        <label for="entradas-vip-input"> Numero de Entradas para zona VIP </label>
                        <input type="number" name="entradas-vip" value="20"  id="entradas-vip-input">
                    </div>
                    <div>
                        <label for="entradas-altos-input"> Numero de Entradas para zona alta </label>
                        <input type="number" name="entradas-altos"  value="20" id="entradas-altos-input">
                    </div>
                    <div>
                        <label for="entradas-platino-input"> Numero de Entradas para zona platino </label>
                        <input type="number" name="entradas-platino" value="20"  id="entradas-platino-input">
                    </div>
                    <div>
                        <label for="entradas-medios"> Numero de Entradas para zona media </label>
                        <input type="number" name="entradas-medios" value="20"  id="entradas-vip-medios">
                    </div>
                    <div>
                        <label for="descripcion-input"> Breve descripcion del evento  </label>
                        <textarea name = "descripcion" id="descripcion-input"  rows="10"></textarea>

                    </div>
                </div>
                <div class="form-image">
                </div>
                <button type="submit"> Agregar Eventos </button>
        </form>
    </main>


</body>
</html>