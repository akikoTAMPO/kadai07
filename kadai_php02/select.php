<?php
// セキュリティ対策
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // insert.php　からコピペしてください
  $pdo = new PDO('mysql:dbname=gs_kadai02;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError'.$e->getMessage());
}

//２．データ取得SQL作成
// すでにあるDBからとってくるためセキュリティ処理無しでOK
$stmt = $pdo->prepare("SELECT * FROM image_table;");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  // SQL実行成功($status == true )した場合▼
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  // 1行とったら $result に格納し、なくなったら終了
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $result の　name　を　$view に格納／　.は追加で格納するという意味
    $view .= '<p>' . $result['id'] . ' / ' . $result['created_at'] . ' / ' . h($result['image_content']) . ' / ' . h($result['memo'])  . '</p>';
    
    
    // var canvas = document.getElementById("drawArea");
  //   $ctx = canvas.getContext("2d");
  // $newImg[] = $result['image_content'];
  // ctx.drawImage(document.getElementById("newImg"), 0, 0, 200, 300);
}
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フ表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->



<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
    <div id="drawarea"></div>
</div>
<!-- Main[End] -->

</body>
</html>
