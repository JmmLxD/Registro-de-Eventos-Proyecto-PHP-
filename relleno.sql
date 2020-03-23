insert into eventos_comprados 
    (serial,username_comprados,nombre_evento,fecha,ubicacion)
    values 
    (122,"user1","evento A",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"altos"),
    (133,"user2","evento B",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"vip"),
    (144,"user3","evento C",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"platino"),
    (155,"jmml","evento D",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"altos"),
    (166,"user1","evento E",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"platino"),
    (177,"user2","evento F",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"platino"),
    (188,"user3","evento G",STR_TO_DATE("2019-2-3",'%Y-%m-%d'),"platino");


     <div>
                    <h3> Datos de Compra </h3>
                    <p>Datos de Evento</p>
                    <ul class="lista-datos" >
                        <li> serial : <span> a</span> </li>
                        <li> nombre de evento : <span> b </span> </li>
                        <li> fecha : <span> </span> c </li>
                        <li> ubicacion : <span> d </span> </li>
                    </ul>
                    <p>Datos de Usuario <span> a </span> </p>
                    <ul class="lista-datos" >
                        <li> nombre : <span> b </span> </li>
                        <li> apellido : <span> c </span> </li>
                        <li> cedula : <span> d </span> </li>
                        <li> direccion : <span> e </span> </li>
                        <li> sexo : <span> </span> f </li>
                        <li> telefono : <span> a </span> </li>
                        <li> email : <span> </span> b </li>   
                    </ul>
                </div>