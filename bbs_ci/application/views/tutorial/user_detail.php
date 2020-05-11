<!DOCTYPE html>
<?php $this->load->view('common/header');?>
<body>
<header class="container">
    <h1>CodeIgniter超入門サンプル</h1>
    <h2>チュートリアル「新規ページをつくってみよう」</h2>
</header>
<article class="container">
    <table class="table table-inverse">
        <thead>
        <tr>
            <th>項目</th>
            <th>内容</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>氏名</th>
            <td><?php if(isset($name)){ echo $name; }?></td>
        </tr>
        <tr>
            <th>都道府県</th>
            <td><?php if(isset($pref)){ echo $pref; }?></td>
        </tr>
        </tbody>
    </table>
</article>
</body>
</html>