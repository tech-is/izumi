<?php
$title = "Main";
include __DIR__ . '/layout/layout.php';
?>
<div class="container">
    <div class="Main-logo">
        <h1>ようこそ！<?= $_SESSION['name'] ?>さん</h1>
    </div>
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
                <th>メルアド</th>
                <th>生まれ年</th>
                <th>性別</th>
                <th>メルマガ</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result_array as $value) {
                echo "<tr><td>" . $value['id'] . "</td>";
                echo "<td>" . $value['name'] . "</td>";
                echo "<td>" . $value['tel'] . "</td>";
                echo "<td>" . $value['mail'] . "</td>";
                echo "<td>" . $value['year'] . "</td>";
                echo "<td>" . $value['sex'] . "</td>";
                echo "<td>" . $value['magazine'] . "</td>";
                
            }
            ?>
        </tbody>
    </table>
    <form method="GET" action="<?php echo base_url() . "main/logout" ?>">
        <div class="float-left">
            <p><input type=submit class="btn btn-primary" name="logout" value="ログアウト"></p>
        </div>
    </form>
</div>
</body>

</html>