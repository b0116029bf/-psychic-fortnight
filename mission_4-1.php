<html>
<head>
	<title>mission_4-1</title>
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
コメント：<input type = "text" name = "comment" placeholder ="コメント"><br>
<input type = "hidden" name = "hensyubango" >
<! hiddenは表示させない->
パスワード：<input type = "text" name ="password"  placeholder ="パスワード">
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
<?php
$sql = "CREATE TABLE IF NOT EXISTS keijiban"//テーブルの作成//
." ("
. "id INT,"//INTは数字型 //
. "name char(32),"//char(文字数  )文字数まで書き込める//
. "comment TEXT,"
. "nitizi DATETIME,"//DATETIMEは日付時刻型//
. "password TEXT"
.");";
$stmt = $pdo->query($sql);
/*IF NOT EXISTSを入れないと２回目以降にこのプログラムを呼び出した際に、 
SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'tbtest' already exists 
という警告が発生。これは、既に存在するテーブルを作成しようとした際に発生するエラー*/
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
	//以下の処理で投稿番号を取得//
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	$sql='SELECT * FROM keijiban';
	$stmt=$pdo->query($sql);
	//SQL文を実行するコードを、変数に格納//
	$stmt->execute();
	$id=$stmt->rowCount();
	//$id にテーブルの行数の合計が入る　投稿番号を取得//
	$id=$id +1;

if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["sukujo"]) && empty ($_POST["hensyu"]) && !empty($_POST["password"])){
//nameとcommentが空欄でない時//
$sql=$pdo->prepare("INSERT INTO keijiban (id,name,comment,nitizi,password) VALUES (:id,:name,:comment,:nitizi,:password)"); 
$sql->bindParam(':id',$id,PDO::PARAM_INT);//INTは数字型//
$sql->bindParam(':name',$name,PDO::PARAM_STR);
//テーブルの作成で設定したnameを使う　(': name    '   )PDO::PARAM_STR は文字型//
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
//テーブルの作成で設定したcommentを使う　(': comment   '   )//
$sql->bindParam(':nitizi',$nitizi,PDO::PARAM_INT);
$sql->bindParam(':password',$password,PDO::PARAM_STR);
$sql->execute();
//作成したテーブルにデータを入力//
}else if(!empty($_POST["sakujo"]) && !empty($_POST["sakujopassword"]) ){
//sakujoが空欄でない時//
$id=$_POST["sakujo"];
$sql=$pdo->prepare("SELECT * FROM keijiban where id =:id"); 
$sql->bindValue(':id',$_POST["sakujo"]);//$id=$sakujoのやつ取り出す//
$sql->execute();
//作成したテーブルにデータを入力//
$results=$sql->fetchAll();
	foreach($results as $row){
	$db_hashed_pwd=$row['password'];//パスワードの取得//
	}
	if($_POST["sakujopassword"]==$db_hashed_pwd){
	//削除パスワードとパスワードが等しいなら//
	$id=$_POST["sakujo"];
	$sql='delete from keijiban where id=:id';
	//入力したデータをdeleteによって削除//
	$stmt = $pdo->prepare($sql);
	//SQL文を実行するコードを、変数に格納//
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	//テーブルの作成で設定したidを使う　(': id   ')   PDO::PARAM_INT は数字型//
	$stmt->execute();
	//作成したテーブルにデータを入力//
	}else{//sakujopasswordと等しいパスワードがない//
	echo('<h1>パスワードが違います。</h1>');	
	}
}

$sql='SELECT * FROM keijiban ORDER BY id ASC';
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
/*$rowの中にはテーブルの作成のところで指定したnitiziの名前['nitizi ']
"nbsp"は通常の半角スペースと同じサイズの空白*/
}
?>
</body>
</html>
