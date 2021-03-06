﻿<?php error_reporting( E_ALL ^ E_NOTICE ); ?><!--注意喚起程度のエラーは非表示 -->
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


 <h1 class="search_title">ミュージシャンの予約</h1>

<?php
//MySQLへの接続
  $pdo = new PDO("mysql:host=localhost; dbname=musicians; charset=utf8", "root", "", array( PDO::ATTR_EMULATE_PREPARES => false) );

//ページしたにあるFORMにあるinput　name=cmd と value=reserveに該当するform内容ならば、以下の自作SQLを実行する。
if( $_REQUEST["cmd"] == "reserve"){
  $sql = <<< SQL
    insert into reservation( artists_id, last_name, first_name,  reserve_date )
      values ( :artists_id, :last_name, :first_name,  :reserve_date) 
SQL;

//index.phpの選択画面で選んだものをMSQLで使える配列用に、コロンのプレースホルダ―にセット。
  $condition = array(
      ":artists_id" => $_REQUEST["id"],
      ":last_name" => $_REQUEST["last_name"],
      ":first_name" => $_REQUEST["first_name"],
      ":reserve_date" => "{$_REQUEST["year"]}-{$_REQUEST["month"]}-{$_REQUEST["day"]}",
      );

//SQLの実行。IF分を用いて、SQLのが真なら（行が送り先がないので、予約確定が実行されれば）下記のメッセージを表示。　検索画面にもどる項目も用意。
    $statement = $pdo->prepare( $sql );
    $result = $statement->execute( $condition );
    if( $result ){
      print ('<center><font size=5px; >');
      print ("ご予約ありがとうございました。 <br /> 24時間以内に返信いたしますので、しばらくお待ちください。");
      print ('</center></font>');
      print ('<center><p><a href="index.php"  class="btn btn-warning"  style="margin-top:20px;">検索画面にもどる</a></p></center>');　//検索画面に戻るボタンも追加。
     ;
  }


}
//上記で自作関数で作ったSQLで、今回選択したものが、一つだけ表示されるようにFETCHで抽出。検索画面では、FetchAll.
$sql = "select * from artists_intro where id = :id ";
$condition = array( ":id" => $_REQUEST["id"]);
$statement = $pdo->prepare( $sql );
$statement->execute( $condition );
$result = $statement->fetch();

 ?>

<table border="1">
<br /><br />
  <caption>予約対象ミュージシャン</caption>
  <tr>
  <th>写真</th>
  <th>ミュージシャン</th>
  <th>料金/1h</th>
  <th>楽器名</th>
  <th>その他</th>
  </tr>


<!--下のテーブルでは、今回選んだものだけをサニタイジングを加え表示 -->
<tr>
  <td>
    <img src="pics/<?php print( htmlspecialchars($result["id"], ENT_QUOTES) ); ?>.jpg" style="padding:20px 0px 20px 20px;"/>
  </td>

   <td>
   <?php print( htmlspecialchars($result["artists_name"], ENT_QUOTES) ); ?>
  </td>
     <td>
   <?php print( htmlspecialchars( number_format($result["price"]) , ENT_QUOTES)  ); ?>
  </td>

  <td>

   <?php print( htmlspecialchars( $result["instruments"], ENT_QUOTES)  ); ?>

  </td>
     
        <td>
   <?php print( htmlspecialchars( $result["memo"] , ENT_QUOTES) ); ?>
  </td>

</tr>




</table>
<!-- 予約項目を入力。actionでの送り先をこのページにすることで、データを表示できる。
各項目でえらんだnameのデータが送信画面に送られる。-->
<form name="reserve_form" method="POST" action="detail.php">
    <input type="hidden" name="cmd" value="reserve">
    <input type="hidden" name="id" value="<?php print ( htmlspecialchars($_REQUEST["id"]) );?>" >

<table border="1"><br />
  <caption>予約情報を入力してください</caption>
<br />

<tr>
  <th>姓</th>
  <td><input type="text" name="last_name" required></td>
</tr>

<tr>
  <th>名</th>
  <td><input type="text" name="first_name" required></td>
</tr>

<tr>
  <th>予約日</th>
  <td><input type="text" name="year" size="4" required> 年<input type="text" name="month" size="2" required>月<input type="text" name="day" size="2" required></td>
</tr>
</table>

<!--ボタン３つ　予約画面に前ページに戻る。　予約確定でaction先はない。　また詳細を問い合わせるボタンでは、問い合わせページに移動できる。 -->
<div class="confirm">
<input class="btn btn-success " value="予約画面に戻る" onClick="history.back();">
<input type="submit" value="予約確定" class="btn btn-danger" >
</div>


<button class="btn btn-warning center-block" style="width:420px; margin-top:20px;" onClick="location.href='contact.html' ">詳細を問い合わせる</button> 

</form>

<br />

<!-- <button onClick="location.href='index.php' ">メイン画面に戻る</button>  -->




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>