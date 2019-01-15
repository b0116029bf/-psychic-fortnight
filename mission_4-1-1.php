<html>
<head>
	<title>mission_4-1-1</title>
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
<?php
$name=$_POST["name"];
$comment= $_POST["comment"];
$nitizi = date("Y/m/d/H:i:s");
$password= $_POST["password"];
$sakujo = $_POST["sakujo"];
$hensyu = $_POST["hensyu"];
$password = $_POST["password"];
$sakujopassword = $_POST["sakujopassword"];
$hensyupassword = $_POST["hensyupassword"];
//フォームに入力された名前とコメント、日時、削除と編集、あとパスワード//
if(!empty($_POST["hensyu"])&& !empty( $_POST["hensyupassword"])){
//echo "hensyu"が空欄でないなら かつ編集のパスワードが空欄でないなら//){
$id=$_POST["hensyu"];
$sql=$pdo->prepare("SELECT * FROM keijiban where id =:id"); 
$sql->bindValue(':id',$_POST["hensyu"]);//$id=$hensyuのやつ取り出す//
$sql->execute();
//作成したテーブルにデータを入力//
$results=$sql->fetchAll();
	foreach($results as $row){
	$db_hashed_pwd=$row['password'];//パスワードの取得//
	}
	if($_POST["hensyupassword"]==$db_hashed_pwd){
	//編集パスワードとパスワードが等しいなら//
	$id=$_POST["hensyu"];
	$sql=$pdo->prepare("SELECT * FROM keijiban where id =:id"); 
	$sql->bindValue(':id',$_POST["hensyu"]);//$id=$hensyuのやつ取り出す//
	$sql->execute();
	//作成したテーブルにデータを入力//
	$results=$sql->fetchAll();
		foreach($results as $row){
		$namehensyu=$row['name'];//nameの取得//
		$commenthensyu=$row['comment'];//commentの取得//
		}
	}else{//hensyupasswordと等しいパスワードがない//
	echo('<h1>パスワードが違います。</h1>');	
	}
}

?>
<form action = "mission_4-1-2.php" method = "POST">
名前：<input type = "text" name = "namehensyugo" value ="<?=$namehensyu?>" placeholder ="名前"><br>
<!-placeholder ="名前"は薄い字で名前と表示->
<!  value="<?=$namehensyu?>"はphpで取り出したnameを表示する->
コメント：<input type = "text" name = "commenthensyugo" value = "<?=$commenthensyu?>" placeholder ="コメント"><br>
<! value = "<?=$commenthensyu?>"はphpで取り出したcommentを表示する->
パスワード：<input type = "text" name ="password"  placeholder ="パスワード">
<input type = "hidden" name = "hensyubango" value = "<?=$hensyu?>">
<input type = "submit" value = "送信"><!-valueにはボタンに表示する名前-><br><br>
</form>
<form action = "mission_4-1.php" method = "POST">
削除対象番号 : <input type = "text" name ="sakujo" placeholder ="削除対象番号"><br>
パスワード：<input type = "text" name ="sakujopassword"  placeholder ="パスワード">
<input type = "submit" value = "削除"><!-valueにはボタンに表示する名前-><br><br>
</form>
<form action = "mission_4-1-1.php" method = "POST">
編集対象番号：<input type = "text" name ="hensyu" placeholder ="編集対象番号" ><br>
パスワード：<input type = "text" name ="hensyupassword"  placeholder ="パスワード">
<input type = "submit" value = "編集"><!-valueにはボタンに表示する名前->
</form>

<?php
$sql='SELECT*FROM keijiban ORDER BY id ASC';
//select文を変数に格納//
$stmt=$pdo->query($sql);
//SQL文を実行するコードを、変数に格納//
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