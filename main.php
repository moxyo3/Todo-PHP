<?php
require_once './db.php';

$pdo = dbConnect();

//Requestのmethodで分岐
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    createTodo();
} elseif($_SERVER["REQUEST_METHOD"] == "GET"){
    getTodo();
} elseif($_SERVER["REQUEST_METHOD"] == "DELETE"){
    deleteTodo();
}

function createTodo(){
//$_POSTにapplication/jsonは渡せないので
//file_get_contents("php://input")でリクエストボディを取得
//POST受取、jsonのデコード
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
    $sql = 'SELECT * FROM todos';
    $stmt = $pdo->query($sql);

    $rows = $stmt-> fetchAll(PDO::FETCH_ASSOC);
    header('Content-type:application/json');
    return json_encode($rows,JSON_UNESCAPED_UNICODE);
}

function deleteTodo(){
}
