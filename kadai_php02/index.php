<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ登録</title>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        /* div {
            padding: 10px;
            font-size: 16px;
        } */
    </style>
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Head[Start] -->
    <!-- <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
            </div>
        </nav>
    </header> -->
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <!-- <form method="post" action="insert.php">
        <div class="jumbotron">
            <fieldset>
                <legend>撮影しましょう</legend>
                <label>名前：<input type="text" name="name"></label><br>
                <label>Email：<input type="text" name="email"></label><br>
                <label><textArea name="content" rows="4" cols="40"></textArea></label><br>
                <input type="submit" value="送信">
            </fieldset>
        </div>
    </form> -->
    <!-- Main[End] -->
    <h1><a class="navbar-brand" href="select.php">データ一覧</a></h1>

    <h1>HTML5カメラ</h1>

<video id="camera" width="200" height="300"></video>
<canvas id="picture" width="200" height="300"></canvas>
<form method="post" action="insert.php">
  <button type="button" id="shutter">シャッター</button>
  <!-- <button type="button" id="save">画像を保存</button> -->
  <input type="submit" id="save" value="画像を保存">
  <br>
  <textarea name="memo" id="memo" cols="30" rows="10"></textarea>
  <br>
  <textarea name="image_name" id="image_name" cols="30" rows="10"></textarea>
</form>

<!-- <audio id="se" preload="auto">
  <source src="camera-shutter1.mp3" type="audio/mp3">
</audio> -->

<script>
window.onload = () => {
  const video  = document.querySelector("#camera");
  const board = document.querySelector("#picture");
//   const se     = document.querySelector('#se');
  console.log('videoを表示：', video);
  console.log('boardを表示：', board);

  /** カメラ設定 */
  const constraints = {
    audio: false,
    video: {
      width: 200,
      height: 300,
      facingMode: "user"   // フロントカメラを利用する
      // facingMode: { exact: "environment" }  // リアカメラを利用する場合
    }
  };

  /**
   * カメラを<video>と同期
   */
  navigator.mediaDevices.getUserMedia(constraints)
  .then( (stream) => {
    video.srcObject = stream;
    video.onloadedmetadata = (e) => {
      video.play();
    };
  })
  .catch( (err) => {
    console.log(err.name + ": " + err.message);
  });

  /**
   * シャッターボタン
   */
   document.querySelector("#shutter").addEventListener("click", () => {
    const ctx = board.getContext("2d");
    console.log('ctxを表示：', ctx);

    // 演出的な目的で一度映像を止めてSEを再生する
    video.pause();  // 映像を停止
    // se.play();      // シャッター音
    setTimeout( () => {
      video.play();    // 0.5秒後にカメラ再開
    }, 500);

    // canvasに画像を貼り付ける
    ctx.drawImage(video, 0, 0, board.width, board.height);
    // document.getElementById('picture').src = board.toDataURL('image/jpeg');
    // console.log('画像名を表示：', document.getElementById('picture').src);

    // Canvasのデータを取得
    let canvas = board.toDataURL("image/png");  // DataURI Schemaが返却される
    // canvas = canvas.replace('data:image/png;base64,', '');
    console.log('canvasを表示：', canvas);
    console.log('canvasの型を表示：', typeof canvas);


    $('#image_name').html(canvas);
  })}

    </script>


</body>

</html>
