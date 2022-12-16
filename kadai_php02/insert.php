<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */
// 接続　→　（DBを）登録　→　終了後の処理　の3段活用が基本

//1. POSTデータ取得
$image_name = $_POST["image_name"];
$memo = $_POST["memo"];
// $param= $_POST["param"];
// $picture= $_POST["picture"];
// $name = $_POST['name'];
// $email = $_POST['email'];
// $content = $_POST['content'];

// echo('$image_nameを表示');
// var_dump($image_name);

//2. DB接続します
try {
  //ID:'root', Password: xamppは 空白 '' ←最後の2コマ
  // = のあとにDB名前を記載▼
  // tryで頑張ってください。エラーをcatchしたら処理をしてください
  $pdo = new PDO('mysql:dbname=gs_kadai02;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意   ""の中にSQL文を書く
$stmt = $pdo->prepare("INSERT INTO
                        image_table(id, created_at, image_content, memo )
                        VALUES(NULL, sysdate(), :image_name, :memo )");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
// formから追加した　$name を処理してからDBに追加しましょう（SQLインジェクション）

$stmt->bindValue(':image_name', $image_name, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
// $stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
// true or false　がかえってくる
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  // 成功したら　index.php へ戻る
  header('Location: index.php');
}
?>
