<?php

//1. POSTデータ取得
$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'];

//2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db_kadai;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO
                gs_bm_table( id, name, url, comment, datetime )
                VALUES( NULL, :name, :url, :comment, now() ) ');

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false) {
    $error = $stmt->errorInfo();
    echo 'ErrorMessage:'.$error[2];
    exit();
} else {
    header('Location: index.php');
    exit();
}