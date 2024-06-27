<?php
require_once('funcs.php');

//1. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db_kadai;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="bookmark-item">';
        $view .= '<h3>' . h($result['name']) . '</h3>';
        $view .= '<p>URL: <a href="' . h($result['url']) . '" target="_blank">' . h($result['url']) . '</a></p>';
        $view .= '<p>コメント: ' . h($result['comment']) . '</p>';
        $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ブックマーク一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">データ登録</a>
        </nav>
    </header>

    <div class="container">
        <h1>ブックマーク一覧</h1>
        <div class="jumbotron">
            <?= $view ?>
        </div>
    </div>
</body>
</html>
