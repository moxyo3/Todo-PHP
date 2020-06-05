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
    global $pdo;
    $content = file_get_contents("php://input");
    //第二引数のtrue: 連想配列にする
    //decode失敗時の戻り値はnull
    $decoded = json_decode($content, true);
    if($decoded === null){
        throw new Exception('JSON decode Error');
    } else {
        $name = $decoded["name"];
        $todo = $decoded["todo"];
        if($name === null || $todo === null) {
            throw new Exception('null Data');
        } else {
            //DB処理
            $sql = 'INSERT INTO todos (name, todo) VALUES (?, ?);';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $todo);
            $stmt->execute();
        }
    }
}

function getTodo(){
    global $pdo;
    $sql = 'SELECT * FROM todos';
    $stmt = $pdo->query($sql);

    $rows = $stmt-> fetchAll(PDO::FETCH_ASSOC);
    header('Content-type:application/json');
    //json_encode失敗時の戻り値はfalse
    $json = json_encode($rows,JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        throw new Exception ('json_encode Error');
    } else {
        echo $json;
    }
}

function deleteTodo(){
    if(is_numeric($_REQUEST["id"]) && $_REQUEST !== null){
        global $pdo;
        $sql= 'DELETE from todos WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1,$_REQUEST["id"]);
        $stmt->execute();
    } else {
        throw new Exception('id error');
    }
}
