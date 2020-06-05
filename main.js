getTodo();

function createTodo(){
    //fetchでajax通信、json形式でphpにpost
    const name = document.getElementById("name");
    const todo = document.getElementById("todo");

    if (name.value  == "" || todo.value == ""){
        alert("未入力の項目を入力してください");
        return;
    } else {

        const form = {
            name: name.value,
            todo: todo.value,
        }
    
        fetch('./main.php', {
            method: 'POST',
            headers: {
                "content-type": "application/json"
            },
            body: JSON.stringify(form),
        }).then((response) => {
            if (response.ok){
                alert("登録しました");
                getTodo();
            } else {
                alert("登録失敗しました");
            }
        }).catch((err) => {
            console.log(err);
        });
    }
}

function getTodo(){
    fetch('main.php').then((response)=>{ 
        return response.json();
    }).then((todos) => {
        for (const todo of todos){
            //buttonプロパティ追加
            todo.button = "button";
        }
        createTable(todos);
    }).catch((err)=> {
        console.log(err);
    })
}

function createTable(todos){
    const table = document.getElementById("table");
    table.innerHTML = "";
    todos.unshift({id:"id", name:"name", todo:"todo",operation:"operation"});

    for(const todo of todos){
        const tr = document.createElement("tr");

        for(const c of Object.values(todo)){
            if(c === "button"){
                const button = document.createElement("button");
                button.textContent = "削除";
                button.onclick = function(){
                    deleteTodo(todo.id);
                };
                tr.appendChild(button);
            } else {
                const td = document.createElement("td");
                td.textContent = c;
                tr.appendChild(td);
            }
        }
        table.appendChild(tr);
    }
}

function deleteTodo(id){
    fetch(`./main.php?id=${id}`,{
        method: 'DELETE',
    }).then((response)=>{
        if(response.ok) {
            alert("削除しました");
            getTodo();
        } else {
            alert("削除失敗しました");
        }
    }).catch((err)=>{
        console.log(err);
    });
}
