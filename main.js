function createTodo(){
    //fetchでajax通信、json形式でphpにpost
    const name = document.getElementById("name");
    const todo = document.getElementById("todo");

    const form = {
        name: name.value,
        todo: todo.value,
    }

    console.log(form.name);
    console.log(form.todo);

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
    })
}
function getTodo(){
    fetch('main.php').then((response)=>{ 
        return response.json();
    }).then((todos) => {
    }
     //createTable(todos);
    ).catch((err)=> {
        console.log(err);
    })
}

function createTable(todos){
    //再読込なしでテーブル再生成
    //documentを動的に生成
    const table = document.getelementbyid("table");
    table.innerHTML = "";
}
