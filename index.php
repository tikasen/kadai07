<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
      <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->
<?php
//2. DB接続
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}
$view="";

//３．SQLを作って送信する。
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY t_time DESC");
$status = $stmt->execute();

//４．
if($status==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
  
}else{
while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
$view .= '<p>'; 
$view .= $result["t_time"] .":". $result["b_name"] ;  
$view .= '</p>'; 
} 
}
?>

<!-- Main[Start] -->
<form method="post" action="insert.php" enctype="multipart/form-data">
            <div class="container jumbotron"><?=$view;?></div>

  <div class="jumbotron">
   <fieldset>
    <legend>本のブックマーク</legend>
     <label>書籍名：<input type="text" name="b_name"></label><br>
     <label>書籍URL：<input type="text" name="b_url"></label><br>
     <label>書籍コメント：<input type="text" name="b_comment"></label><br>
<input type="file" name="userfile" accept="image/*">

     <input type="submit" value="送信">

    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
