function createTodo(){
    alert("js読み込み");
    //fetchでajax通信、json形式でphpにpost
    const name = document.getelementbyid("name");
    const todo = document.getelementbyid("todo");

    fetch("main.php", {
        method: "post",
        headers: {
            "content-type": "application/json"
        },
        body: json.stringify({
            "name": name;
            "todo": todo;
        })
    }).then(response => {
        return response.json();)
    })
    .then(json=> {
        console.log(json);
    })
    .catch(e => {
        console.error(e);
    });
//成功したらcreatetable呼ぶ
}

function createtable(){
    //再読込なしでテーブル再生成
    //documentを動的に生成
    const table = document.getelementbyid("table");
    table.innerhtml = "";
}
