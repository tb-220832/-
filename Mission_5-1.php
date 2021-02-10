<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>mission_5-1</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Calistoga&display=swap');
    </style>    
    <link rel="stylesheet" href="Mission_5-1.css">
</head>
<body style="background-color:#a3b9e0;">

<?php
	//$dsnの式の中にスペースを入れないこと！

	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
    //テーブル名
    $tablename="mission5";
    //パスワード
    $pass="phplove";

     //編集フォーム
    if(!empty($_POST["edit"])&&($_POST["pass3"])==$pass){
        //データの取得・表示
        $sql='SELECT*FROM mission5 WHERE id=:id';
        $stmt = $pdo->prepare($sql);                  //差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $_POST["edit"], PDO::PARAM_INT);// 差し替えるパラメータの値を指定してから
        $stmt->execute();                             //SQLを実行する。
        $results = $stmt->fetchAll(); 
	    foreach ($results as $row);
    }
    ?>
    <h1><font color="#ffffff">WHAT IS YOUR FAVORITE APPS ??</font></h1>
    <h3>おすすめのスマホアプリを教えて！
    <br>ゲームアプリでも写真アプリでもなんでも投稿してOK</h3>
    <br>
    投稿フォーム
    <br>
    <form action="" method="post">
    <input type="text" name="name"placeholder="名前"
    value="<?php if(empty($_POST["edit"])){echo"";}else{echo $row['name'];}?>">
    <br>
    <input type="text" name="comment"placeholder="コメント"
    value="<?php if(empty($_POST["edit"])){echo"";}else{echo $row['comment'];}?>">
    <br>
    <input type="text" name="pass1" placeholder="パスワード">
    <br>
    <input type="submit" name="submit" style="background-color:#ffd3e0;">
    <input type="hidden" name="edit2" value="<?php if($_POST["pass3"]==$pass){echo $_POST["edit"];}?>">
    <br><br>
    削除フォーム
    <br>
    <input type="number" name="delete"placeholder="投稿番号">
    <br>
    <input type="text" name="pass2" placeholder="パスワード">
    <br>
    <input type="submit" name="submit" value="削除" style="background-color:#ffd3e0;">
    <br><br>
    編集フォーム
    <br>
    <input type="number" name="edit" placeholder="編集対象番号">
    <br>
    <input type="text" name="pass3" placeholder="パスワード">
    <br>
    <input type="submit" name="submit" value="編集" style="background-color:#ffd3e0;">
    <br>
    <br>
    </form>
    <?php
    //編集モード
    //テキストファイル内が空か確認
    if((!empty($_POST["name"]))&&(!empty($_POST["comment"]))
    &&(!empty($_POST["edit2"]))){
        //UPDATE文でデータを編集
        $sql = 'UPDATE mission5 SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);//実行したいSQL文をセットする
	    $stmt->bindParam(':name',$_POST["name"], PDO::PARAM_STR);
	    $stmt->bindParam(':comment',$_POST["comment"], PDO::PARAM_STR);
	    $stmt->bindParam(':id', $_POST["edit2"], PDO::PARAM_INT);
	    $stmt->execute();
    }
    //新規投稿モード
    if((!empty($_POST["name"]))&&(!empty($_POST["comment"]))
    &&((empty($_POST["edit2"]))||(empty($_POST["edit"])))&&($_POST["pass1"])==$pass){
        //名前とコメントが送信されたときのファイル動作        
        $sql = $pdo->prepare("INSERT INTO mission5 (name, comment)VALUES (:name, :comment)");
	    $sql->bindParam(':name',$_POST["name"], PDO::PARAM_STR);
	    $sql->bindParam(':comment',$_POST["comment"], PDO::PARAM_STR);
	    $sql->execute();
	}
    //削除フォーム
    if(!empty($_POST["delete"])&&($_POST["pass2"])==$pass){
    $id = $_POST["delete"];
	$sql = 'delete from mission5 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id',$id, PDO::PARAM_INT);
	$stmt->execute();
    }
        //データの取得・表示
        $sql = 'SELECT * FROM mission5';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	    echo "<hr>";
        }
    ?>
</body>
</html>