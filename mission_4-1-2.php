<html>
<head>
	<title>mission_4-1-2</title>
	<meta charset="utf-8">
<?php
$dsn='データベース名';
$user ='ユーザー名';
$password='パスワード'; 
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
//データベースへ接続//
/*array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
 データベース操作で発生したエラーを警 告として表示してくれる設定をするための要素*/
?>
</head>
<body>
<form action = "mission_4-1.php" method = "POST">
名前：<input type = "text" name = "name" placeholder ="名前"><br>
<!-placeholder ="名前"は薄い字で名前と表示->
コメント：<input type = "text" name = "comment" placeholder ="コメント">
<input type = "hidden" name = "hensyubango" ><br>
<! hiddenは表示させない->
パスワード：<input type = "text" name ="password" placeholder ="パスワード">
<input type = "submit" value = "送信"><!-valueにはボタンに表示する名前-><br><br>
削除対象番号 : <input type = "text" name ="sakujo" placeholder ="削除対象番号"><br>
パスワード：<input type = "text" name ="sakujopassword"  placeholder ="パスワード">
<input type = "submit" value = "削除"><!-valueにはボタンに表示する名前-><br><br>
</form>
<form action = "mission_4-1-1.php" method = "POST">
編集対象番号：<input type = "text" name ="hensyu"  placeholder ="編集対象番号"><br>
パスワード：<input type = "text" name ="hensyupassword"  placeholder ="パスワード">
<input type = "submit" value = "編集"><!-valueにはボタンに表示する名前->
</form>
<?php>
$password = $_POST["password"];
$sakujopassword = $_POST["sakujopassword"];
$hensyupassword = $_POST["hensyupassword"];
$namehensyugo =$_POST["namehensyugo"];
//namehensyugo (編集した後のやつ)を取り出す//
$commenthensyugo =$_POST["commenthensyugo"];
//commenthensyugo (編集した後のやつ)を取り出す//
$hensyubango =$_POST["hensyubango"];
if(!empty($_POST["namehensyugo"]) && !empty($_POST["commenthensyugo"]) && !empty($_POST["hensyubango"])){
// nameとcommentが空欄ではないなら//
$id=$_POST["hensyubango"];
$name =$_POST["namehensyugo"];
$comment=$_POST["commenthensyugo"];
//変更したいname、変更したいcomment//
$sql='update keijiban set name=:name,comment=:comment where id=:id'; 
//updateによって編集//
$stmt = $pdo->prepare($sql); 
//SQL文を実行するコードを、変数に格納//
$stmt->bindParam(':name',$name,PDO::PARAM_STR);
//テーブルの作成で設定したnameを使う　(': name    '   )PDO::PARAM_STR は文字型//
$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
//テーブルの作成で設定したcommentを使う　(': comment    '   )PDO::PARAM_STR は文字型//
$stmt->bindParam(':id', $id,PDO::PARAM_INT);
//テーブルの作成で設定したidを使う　(': id   ')PDO::PARAM_INT は数字型//
$stmt->execute();
//作成したテーブルにデータを入力//
}

$sql='SELECT*FROM keijiban ORDER BY id ASC';
//selectを変数に格納//
$stmt=$pdo->query($sql);
//SQL文を実行するコードを変数に格納//
$results=$stmt->fetchAll();
foreach($results as $row){
echo $row['id'].'&nbsp';
/*$rowの中にはテーブルの作成のところで指定したidの名前 ['id     ']
"nbsp"は通常の半角スペースと同じサイズの空白*/
echo $row['name'].'&nbsp';
/*$rowの中にはテーブルの作成のところで指定したnameの名前['name    ']
"nbsp"は通常の半角スペースと同じサイズの空白*/
echo $row['comment'].'&nbsp';
/*$rowの中にはテーブルの作成のところで指定したcommentの名前['comment ']
"nbsp"は通常の半角スペースと同じサイズの空白*/
echo $row['nitizi'].'<br>';
/*$rowの中にはテーブルの作成のところで指定したcommentの名前['nitizi ']
"nbsp"は通常の半角スペースと同じサイズの空白*/

}

?>
</body>
</html>