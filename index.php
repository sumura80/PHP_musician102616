<?php error_reporting( E_ALL ^ E_NOTICE ); ?><!--注意喚起程度のエラーは非表示 -->
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
 
<div class="search_title">
<h1>優秀なミュージシャンを検索できます。</h1>

 <p style="font-size:20px">1000円から1万円までのミュージシャンをご覧いただけます。</p>
</div>

<!--検索項目のFORMを作成　送信先をこのページにすることで、検索した内容が表示されるようになっている。-->
<form name="search_form" action="index.php" method="post" >
<input type="hidden" name="cmd" value="search" />

<div class="search_tbl">
 
<table>
<tr>
<th class="price_input">価格帯</th>
<td>
  <input type="text" name="price_min" value="<?php print( htmlspecialchars($_REQUEST["price_min"] ,ENT_QUOTES) ) ?>" size="8"> ～

    <input type="text" name="price_max" value="<?php print( htmlspecialchars($_REQUEST["price_max"] ,ENT_QUOTES) ) ?>" size="8">

</td>
</tr>
   
<tr>
<th class="price_input">楽器名</th>
  <td>
    <input type="text" name="instruments" value="<?php print( htmlspecialchars($_REQUEST["instruments"] ,ENT_QUOTES) ) ?>">
  </td>

</tr>
</table>
<br />
<div class="search_btn">
<input type="submit" class="btn btn-info center-block" value="検索">
</div>
</div><!-- END  class="search_tbl" -->


</form>

<!--END　検索項目のFORM-->

<?php
//MySQLへの接続
if( $_REQUEST["cmd"] == "search" ){
  $pdo = new PDO("mysql:host=mysql605.db.sakura.ne.jp; dbname=polyglot80_musicians; charset=utf8", "polyglot80", "sumura80", array( PDO::ATTR_EMULATE_PREPARES => false ) );
  $sql = "select * from artists_intro where 1 = 1 ";
  $condition = array();

//価格を入力する欄で、金額が入力されている際には、SQLに最低金額として式を追加。また最低金額としてSQLで使われるConditioinという配列に追加。
  if( !empty( $_REQUEST["price_min"] ) ){
    $sql = $sql . " and price >= :price_min ";
    $condition[":price_min"] = $_REQUEST["price_min"];
  }
//価格を入力する欄で、金額が入力されている際には、SQLに最高金額として式を追加。また最高金額としてSQLで使われるConditioinという配列に追加。
  if( !empty( $_REQUEST["price_max"] ) ){
    $sql = $sql . " and price <= :price_max ";
    $condition[":price_max"] = $_REQUEST["price_max"];
  }

//楽器名も入力でき、その単語を含むものをLIKE%%で検索できる。　入力した単語がCondition配列に追加される。
  if( !empty( $_REQUEST["instruments"] ) ){
    $sql = $sql . " and instruments like :instruments ";
    $condition[":instruments"] = "%{$_REQUEST["instruments"]}%";
  }
//prepareでSQL式を用意し、Executeで実行。Condition配列で出てきたものをFetchallですべて抽出しまとめたものをResultに代入。
    $statement = $pdo->prepare( $sql );
    $statement->execute( $condition );
  $results = $statement->fetchAll();
?>

<br />
<table border="1" >
<tr>
  <th>紹介写真</th>
  <th>ミュージシャン</th>
  <th>料金/1h</th>
  <th>楽器名</th>
  <th>備考</th>
  <th>ご予約</th>
</tr>
  <?php
  //Foreachを使い、すべて取り出し resultにひとつづつとして格納。
      foreach( $results as $result){
  ?>
<!-- Foreachで抽出したResultをそれぞれの項目でPHPを使い取り出し、画面に表示。
写真の result["id"]なら一つ目の写真、その他も一つ目を表示して、終わり次第二つ目に格納されているものを表示、全て表示。-->
    <tr>
       <td>
         <img src="pics/<?php print( htmlspecialchars($result["id"]) );?>.jpg" style="padding:20px 0px 20px 20px;"/>

       </td>

       <td>
         <?php print( htmlspecialchars($result["artists_name"],ENT_QUOTES) );?>
       </td>
        <td>
         <?php print( htmlspecialchars (number_format($result["price"]) ,ENT_QUOTES)  ) ;?>
        　　
       </td>
       <td>
         <?php print( htmlspecialchars($result["instruments"], ENT_QUOTES)); ?>
       </td>
  
         <td>
         <?php print( htmlspecialchars($result["memo"], ENT_QUOTES)); ?>
       </td>
<!-- 予約ボタンを押下すると、登録画面のdetail.phpに飛び、押下したボタンに該当するIDも一緒に送り、何が選択されたのかがわかる。-->
       <td><a href="detail.php?id=<?php print( $result["id"] ); ?>" class="btn btn-danger btn-sm" style="width: 100px; margin-left:20px;">予約</a>
       </td>
</tr>
    　



<?php 
}
}
?>

</table> 

    


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>