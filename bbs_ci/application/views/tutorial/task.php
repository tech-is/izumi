<!DOCTYPE html>
<html lang="ja">
<?php $this->load->view('common/header');?>
<body>
<header class="container">
    <h1>CodeIgniter超入門</h1>
    <h2>チュートリアル「タスクリストを作ってみよう」</h2>
</header>
<div class="container">
    <form method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">新規タスク</label>
            <input type="text" name="task" class="form-control" placeholder="タスク名" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">タスク追加</button>
    </form>

    <?php
        if(isset($create) and $create === true){   // $data["create"]がtrueの時に表示されます
            echo "
                <div class=\"alert alert-success\" role=\"alert\">
                    タスクを追加しました。
                </div>
            ";
        }elseif(isset($create) and $create === false){
            echo "
                <div class=\"alert alert-danger\" role=\"alert\">
                    タスクの追加に失敗しました
                </div>
            ";
        }
    ?>


    <table class="table table-inverse">
        <thead>
        <tr>
            <th>タスク</th>
            <th>登録日</th>
        </tr>
        </thead>
        <tbody>
            <?php
            if(isset($task_list) and count($task_list) > 0){
                foreach($task_list as $item)
                {
                    ?>
                    <tr>
                        <td><?php echo html_escape($item['task_name']); ?></td>
                        <td>
                            <?php echo $this->interval_lib->calc($item['created_at']);?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>

</div>
</body>
</html>