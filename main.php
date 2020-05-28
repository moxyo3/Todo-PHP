<?php
//$_POSTにapplication/jsonは渡せないので
//file_get_contents("php://input")でリクエストボディを取得
//json_decodeでパースする
    //POST受取、jsonのデコード
    $content = file_get_contents("php://input");
    //第二引数のtrue: 連想配列にする
    $decoded = json_decode($content, true);
    $name = $decoded["name"];
    $todo = $decoded["todo"];

    //DB接続
    try {
        //PDOインスタンス生成
        $pdo = new PDO(
            "mysql:host=localhost; dbname=test_db; charset=utf8mb4",
            'moxyooo',
            'moxyooo',
        );
        $stmt = $pdo->prepare('INSERT INTO todos (name, todo) VALUES (?, ?);');
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $todo);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
