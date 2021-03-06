<?php
define('DB_USERNAME','moxyooo');
define('DB_PASSWORD','moxyooo');
define('DSN','mysql:host=localhost; dbname=test_db; charset=utf8mb4');

try {
    //PDOインスタンス生成
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD,
    array(PDO::ATTR_PERSISTENT => true
    ));
    //DBへの接続を維持、再利用
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
