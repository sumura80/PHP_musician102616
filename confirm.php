<?php error_reporting( E_ALL ^ E_NOTICE ); //注意喚起程度のエラーは非表示  
	session_start();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>お問い合わせフォーム</title>

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

<div class="page-header well">
　<h1>最終確認画面</h1>
</div><!--END  page-header -->

<div class="reconfirm">
<?php
//名前の表示
print '<p>お名前:' .htmlspecialchars($_REQUEST['handle']). '</p>' ;
//メールアドレスの表示 
print '<p>メールアドレス:' .htmlspecialchars($_REQUEST['email']). '</p>';

//性別を表示する　
    print '<p> 性別：' . $_REQUEST['gender'] . '</p>';
//年齢を表示
switch ($_REQUEST['age']){
	case '10+':
	case '20+':
	case '30+':
	case '40+':
	case '50+':
	case '60+':
	$check['age'] = $_REQUEST['age'];
	break;
//エラーを表示するとき
	default:
	$check['age'] = '年齢を選択してください';
	break;

}
 print'<p>年齢：' .$check['age']. '</p>';

	//好きなジャンルを表示
	print '<p>お好きなジャンル:';
	if(isset($_REQUEST['genre'])){

	//選んだジャンルのものを取り出す
		foreach($_REQUEST['genre'] as $value　){
			print $value　. ', ';
		} 
	 } '</p>'; 

		//感想・質問を表示
	  print '<p> ご感想・ご質問：' . htmlspecialchars($_REQUEST['opinion']) . '</p>';

		//Sessionに入力データを保存
		$_SESSION['handle'] = $_REQUEST['handle'];
		$_SESSION['email'] = $_REQUEST['email'];
		$_SESSION['gender'] = $_REQUEST['gender'];
		$_SESSION['age'] = $_REQUEST['age'];
		$_SESSION['genre'] = $_REQUEST['genre'];
		$_SESSION['opinion'] = $_REQUEST['opinion'];
?>

<br />
<p style="font-size: 28px;">この内容で送信してもよろしいでしょうか？</p><br/>
</div><!-- End Reconfirm-->

<br/>
<button class="btn btn-dfault" onClick="history.back();" style="margin-right:10px">修正する</button> 
<button class="btn btn-info" onclick="location.href='sendmail.php' ">送信</button>

 




 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>