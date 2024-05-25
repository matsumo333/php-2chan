<?php
date_default_timezone_set("Asia/Tokyo");

$comment_array = array();
$pdo = null;
$stmt = null;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bbs-yt', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die('データベース接続に失敗しました。');
}

//フォームを打ち込んだ時
if (!empty($_POST["submitButton"])) {
    $postDate = date("Y-m-d H:i:s");
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // フォームデータのバリデーション
    if (empty($username) || empty($comment)) {
        echo '名前とコメントを入力してください。';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO `bbs-table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate);");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':postDate', $postDate);
            $stmt->execute();
            echo '投稿が成功しました。';
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo '投稿に失敗しました。詳細: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
//DB接続
try {
    $pdo =  new PDO('mysql:host=localhost;dbname=bbs-yt', 'root', '');
} catch (PDOException $e) {
    echo $e->getMessage();
}

//DBからコメントデータを取得する
$sq1 = "SELECT  `id` ,`username`,`comment`,`postDate` FROM `bbs-table`";
$comment_array = $pdo->query($sq1);
$pdo = null;



?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2チャンネル掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="title">PHPで掲示板アプリ</h1>
    <hr>
    <div class="boardWrapper">
        <section>
            <?php foreach ($comment_array as $comment) : ?>
                <article>
                    <div class="wrapper">
                        <div class="nameArea">
                            <span>名前：</span>
                            <p class="username"><?php echo $comment["username"] ?></p>
                            <time><?php echo $comment["postDate"] ?></time>
                        </div>
                        <p class="comment"><?php echo $comment["comment"] ?>
                </article>
            <?php endforeach ?>
        </section>
        <form method="POST" action="" class="formWrapper">
            <div>
                <input type="submit" value="書き込む" name="submitButton">
                <label for="usernameLabel">名前：</label>
                <input type="text" name="username">
            </div>
            <div>
                <textarea class="commentTextArea" name="comment"></textarea>
            </div>
        </form>
    </div>

</body>

</html>