<?php
require_once './db.php';

//Requestのmethodで分岐
switch ($_SERVER["REQUEST_METHOD"]){
    case "POST":
        createTodo();
        break;
    case "GET":
        getTodo();
        break;
    case "DELETE":
        deleteTodo();
        break;
}

function createTodo(){
//$_POSTにapplication/jsonは渡せないので
//file_get_contents("php://input")でリクエストボディを取得
//POST受取、jsonのデコード
    $pdo = dbConnect();
    $content = file_get_contents("php://input");
    //第二引数のtrue: 連想配列にする
    $decoded = json_decode($content, true);
    $name = $decoded["name"];
    $todo = $decoded["todo"];

    $sql = 'INSERT INTO todos (name, todo) VALUES (?, ?);';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $todo);
    $stmt->execute();
}

function getTodo(){
    $pdo = dbConnect();
    $sql = 'SELECT * FROM todos';
    $stmt = $pdo->query($sql);

    $rows = $stmt-> fetchAll(PDO::FETCH_ASSOC);
    header('Content-type:application/json');
    echo json_encode($rows,JSON_UNESCAPED_UNICODE);
}

function deleteTodo(){
    $pdo = dbConnect();
    $sql= 'DELETE from todos WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1,$_REQUEST["id"]);
    $stmt->execute();
}
