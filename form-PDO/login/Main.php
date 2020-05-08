<?php
require_once("./core./core.php");
require_once("./core./encode_csv.php");
logout_session();
$members = Table();
isset($_GET["dl"])? dlCsv(): false;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<title>会員情報画面</title>
<style>
    body{
        padding : 50px;
    }
    h1 {
        margin-bottom: 20px;
        padding: 20px 0;
        text-align: center;
        color: #209eff;
        font-size: 122%;
        border-top: 1px solid #999;
        border-bottom: 1px solid #999;
    }
</style>
<!-- Bootstrap CSS -->
<link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>会員情報画面</h1>
        <?="<p>ようこそ！ <b>" .$_SESSION["name"]. "</b>さん</p>"?>
        <form action="" method="GET">
            <div class="float-right">
                <p><input type="submit" class="btn btn-primary" name="dl" value="csvダウンロード"></p>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>電話番号</th>
                    <th>MAIL</th>
                    <th>生まれ年</th>
                    <th>性別</th>
                    <th>メールマガジン</th>
                    <th>PASSWORD</th>
                </tr>
                </thead>
            <tbody>
            <?php
                for($i = 0; $i < count($members); $i++){
                    $data = $members[$i];
                    echo "<tr><td>" .$data['id']. "</td>";
                    echo "<td>" .$data['name']. "</td>";
                    echo "<td>" .$data['tel']. "</td>";
                    echo "<td>" .$data['mail']. "</td>";
                    echo "<td>" .$data['year']. "</td>";
                    echo "<td>" .$data['sex']. "</td>";
                    echo "<td>" .$data['magazine']. "</td>";
                    echo "<td>" .$data['password']. "</td></tr>";
                }
            ?>
            </tbody>
        </table>
        <form method="GET" action="">
            <p><input type=submit class="btn btn-primary" name="logout" value="ログアウト"></p>
        </form>
    </div> <!-- <div class="container"> -->
</body>
</html>