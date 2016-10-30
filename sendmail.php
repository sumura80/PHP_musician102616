<?php error_reporting( E_ALL ^ E_NOTICE ); //注意喚起程度のエラーは非表示  
	session_start();
//Sessionを使いデータを使えるようにしているので、ページの頭にSession　startと記述。
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ミュージシャン検索</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>
  

<?php
//言語とデータ交換方式を選択。
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	//UTFは必ず大文字にすること

	//下記では、変数に内容を代入。Sessionで持ってきたデータをメールの本文にいれるためのcontentsに代入。
	//. "\n" .で改行を結合し、送信フォームを整えている。
	$from ="From:";
	$to = 'susumu@polyglot80.sakura.ne.jp';
	$subject = 'お問い合わせ内容';
$contents = 
	  '名前：' .$_SESSION['handle']. "\n" .
	  'メールアドレス：' .$_SESSION['email']. "\n" .
	  '性別：' .$_SESSION['gender']. "\n" .
	  '年齢：' .$_SESSION['age']. "\n" .
	  'ジャンル：' . implode(',', $_SESSION['genre']). "\n".
	  '問い合わせ：' .$_SESSION['opinion']. "\n";
//上で変数を作成したので、mb_send_mailで実行し、同時にresult変数に代入。
	$result = mb_send_mail($to, $subject, $contents, $from);
	//mb_send_mailで実行が真（実行されれば）なら下記の内容をprintで表示する。実際のサーバー環境ではメール送信とデータベースへの格納が成功。
	if($result) {
		print ('<font size=5px; >');
		print 'ご送信ありがとうございました。';
		print ('</font>');
		print'<p><a href="index.php">検索画面にもどる</a></p>';
	}else {
		'メール送信に失敗しました。';
	}

 //Sessionは最後に必ず	destroyで終了する。
session_destroy();


?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>