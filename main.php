<?php
function createTodo(){
    $formData = json_decode(file_get_contents('php://input'), true);
$name = $formData["name"];
$todo = $formData["todo"];
echo $name;
echo $todo;

//POST受取、jsonのデコード
//DB接続処理
}
