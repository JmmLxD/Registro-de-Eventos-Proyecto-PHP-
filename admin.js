window.addEventListener("load",()=>{
    fetch("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
        method: 'POST', 
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
        body: "action=get-eventos"
    })
    .then( res => res.json() )
    .then( d => {
        if(d.status == "ok")
            tablaEventos(d); 
    });
});


function tablaEventos(data)
{
    let table = document.createElement("table");
    table.classList.add("tabla-de-eventos");
    let thead = document.createElement("thead");
    thead.innerHTML = ` <tr>
                            <th> Nombre </th>
                            <th> Apellido </th>
                            <th> Cedula </th>
                            <th> Nombre de Evento </th>
                            <th> Ubicacion </th>
                            <th> Acciones </th>
                        <tr>`
    table.append(thead);
    for(let row of data.eventos)
    {
        let tr = document.querySelector("#evento-row-template").content.cloneNode(true).querySelector("tr");
        tr.setAttribute("data-serial",row["serial"]);
        insertTextToDom(row,".td-field-",tr);
        table.append(tr);
    }

    document.querySelector("#main").append(table);

    addTableEvents();


    function addTableEvents()
    {
        let delBtns = document.querySelectorAll(".table-btn-delete");
        for(let btn of delBtns)
        {
            btn.addEventListener("click",async() => {
                let tr = btn.parentElement.parentElement;
                let response = await fetch("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
                    method: 'POST', 
                    headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                    }, 
                    body: "action=delete-evento&serial=" + tr.getAttribute("data-serial")
                });
                tr.remove();
            });
        }

        let showBtns = document.querySelectorAll(".table-btn-show");
        for(let btn of showBtns)
        {
            btn.addEventListener("click",async() => {
                let tr = btn.parentElement.parentElement;
                let dataTr = document.querySelector("#show-datos-template").content.cloneNode(true).querySelector("tr");
                let serial = btn.parentElement.parentElement.getAttribute("data-serial");

                let response = await fetch("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                    body: "action=get-eventos&serial=" + serial
                })
                let data = (await response.json()).eventos[0];
                
                insertTextToDom(data,".info-",dataTr);
                dataTr.querySelector(".close-btn").addEventListener("click",()=>{
                    dataTr.remove();
                })
                tr.parentNode.insertBefore( dataTr , tr.nextSibling);
            });
        }

        let editBtns = document.querySelectorAll(".table-btn-edit");
        for(let btn of editBtns)
        {
            btn.addEventListener("click",async() => {
                let tr = btn.parentElement.parentElement;
                let editTr = document.querySelector("#edit-data-template").content.cloneNode(true).querySelector("tr");
                let serial = btn.parentElement.parentElement.getAttribute("data-serial");
                let response = await fetch("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                    body: "action=get-eventos&serial=" + serial
                })
                let data = (await response.json()).eventos[0];
                tr.parentNode.insertBefore( editTr , tr.nextSibling);
                //pendiende cambiar esto por clases y tal
                serial = data["serial"];
                editTr.querySelector("#nombre-input").value = data["nombre_evento"];
                editTr.querySelector("#serial-input").value = data["serial"];
                editTr.querySelector("#fecha-input").value = data["fecha"];
                editTr.querySelector("#ubicacion-input").value = data["ubicacion"];
                editTr.querySelector("#comprador-username-input").value = data["username"];

                editTr.querySelector("form").addEventListener("submit",async (ev)=>{
                    ev.preventDefault();
                    let form = editTr.querySelector("form");
                    let fd = new FormData(form);
                    let data = {};
                    fd.forEach( (value,key) => {
                        if(key == "serial")
                        {
                            data["new-serial"] = value;
                            data["serial"] = serial;
                        }
                        else
                            data[key] = value;
                    });
                    data["action"] = "edit-evento";
                    console.log(data);
                    console.log((new URLSearchParams(data)).toString());
                    let request = new Request("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
                        method: 'POST', 
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                        body: new URLSearchParams(data).toString()
                    });

                    let response = await fetch(request);
                    let dataRes = await response.text();
                    console.log(dataRes);
                    editTr.remove();
                });
            });
        }
    }
}


function insertTextToDom(data,prefix = "",root = document)
{
    for(let field of Object.keys(data))
    {
        let el = root.querySelector(prefix + field);
        if(el)
        {
            el.innerText = data[field];
        }
    }
}