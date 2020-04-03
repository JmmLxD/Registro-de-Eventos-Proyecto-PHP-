window.addEventListener("load",async ()=> {

    let response = await adminPostRequest({"action":"get-eventos"});
    
    if(response.status == "ok")
    {
        tablaEventos(response.eventos);
    }
});


function tablaEventos(eventos)
{
    let table = document.createElement("table");
    table.classList.add("tabla-de-eventos");
    let thead = document.createElement("thead");
    thead.innerHTML = ` <tr>
                            <th> NOMBRE </th>
                            <th> APELLIDO </th>
                            <th> CEDULA </th>
                            <th> NOMBRE DE EVENTO </th>
                            <th> UBICACIONES </th>
                            <th> ACCIONES </th>
                        <tr>`
    table.append(thead);
    console.log(eventos);
    for(let row of eventos)
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
                let serial = tr.getAttribute("data-serial");
                let response = await adminPostRequest({"action":"delete-evento","serial":serial});
                if(response.status === "ok")
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
                 
                let response = await adminPostRequest({"action":"get-eventos","serial":serial});
                let data = response.eventos[0];

                btn.setAttribute("disabled","true");
                btn.classList.add("btn-active");
                insertTextToDom(data,".info-",dataTr);
                dataTr.querySelector(".close-btn").addEventListener("click",()=>{
                    btn.removeAttribute("disabled");
                    btn.classList.remove("btn-active");
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

                let data = (await adminPostRequest({"action":"get-eventos","serial":serial})).eventos[0];
                tr.parentNode.insertBefore( editTr , tr.nextSibling);

                //pendiende cambiar esto por clases y tal
                serial = data["serial"];
                editTr.querySelector("#evento-input").value = data["nombre_evento"];
                editTr.querySelector("#serial-input").value = data["serial"];
                editTr.querySelector("#fecha-input").value = data["fecha"];
                editTr.querySelector("#ubicacion-input").value = data["ubicacion"];
                
                let usernames = (await adminPostRequest({"action":"username-list"})).usernames;
                let usernamesI =  editTr.querySelector("#comprador-username-input");
                for(let u of usernames)
                {
                    let op = document.createElement("option");
                    op.value = u;
                    if(u == data["username"])
                        op.setAttribute("selected",true);
                    op.innerText = u;
                    usernamesI.append(op);
                }

                btn.setAttribute("disabled","true");
                btn.classList.add("btn-active");

                                
                let response = (await adminPostRequest({"action":"eventos-list"}));
                let eventoI =  editTr.querySelector("#evento-input");
                console.log(response);
                response.eventos.forEach( (evento , i) =>{
                    let op = document.createElement("option");
                    op.value = evento["id"];
                    if(i == 1)
                        op.setAttribute("selected",true);
                    op.innerText = evento["nombre"];
                    eventoI.append(op);
                })

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
                    data["username-comprador"] = data["username"];
                    delete data["username"];

                    let response = await adminPostRequest(data);
                    if(response.status == "ok")
                    {
                        let updatedData = response.newData;
                        btn.removeAttribute("disabled");
                        btn.classList.remove("btn-active");
                        tr.setAttribute("data-serial",updatedData["serial"]);
                        insertTextToDom(updatedData,".td-field-",tr);
                        editTr.remove();
                    }
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

async function adminPostRequest(data,to = "json")
{

    let request = new Request("http://localhost:8888/Registro-de-Eventos-Proyecto-PHP-/admin_action.php",{
        method: 'POST', 
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
        body: new URLSearchParams(data).toString()
    });
    if(to == "json")
        return  await (await fetch(request)).json();
    else if(to == "text")
        return  await (await fetch(request)).text();
    else 
        return null;
}