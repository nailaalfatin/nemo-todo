<?php
include 'db.php';

// proses insert data
if(isset($_POST['add'])) {
    $q_insert = "INSERT INTO task (task_label, task_status) VALUE (
        '".$_POST['task']. "',
        'open'
    )";
    $run_q_insert = mysqli_query($conn, $q_insert);
    if($run_q_insert) {
        header('Refresh:0; url=todo.php');
    }
}

// show data

$q_select = "SELECT * FROM task ORDER BY task_id DESC";
$run_q_select = mysqli_query($conn, $q_select);

// delete data
if(isset($_GET['delete'])) {
    $q_delete = "DELETE FROM task WHERE task_id = '".$_GET['delete']."'";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header('refresh:0; url=todo.php');
}

// update status data (open/close)
if(isset($_GET['done'])){
    $status = 'close';

    if($_GET['status'] == 'open'){
        $status='close';
    }else{
        $status='open';
    }

    $q_update = "UPDATE task SET task_status = '".$status."' WHERE task_id = '".$_GET['done']."'";
    $run_q_update = mysqli_query($conn, $q_update);
    header('Refresh:0; url=todo.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="styless.css">
    <!-- ini link box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="container">
        <!-- ini untuk header -->
        <div class="header">
            <div class="title">
                <span>nemo.</span>
            </div>

            <div class="description">
                <?= date("l, d M Y") ?>
            </div> 
        </div>

        <!-- ini untuk konten -->
        <div class="content">
            <div class="card">
                <form action="" method="post">
                    <input name="task" type="text" class="input-control" placeholder="Pencil it in">
                    <div class="text-right">
                        <button type="submit" name="add">Add</button>
                    </div>
                </form>
            </div>

            <!-- ini untuk tugas -->
            <?php
            if(mysqli_num_rows($run_q_select) > 0) {
                while($r = mysqli_fetch_array($run_q_select)) {
            ?>
            <div class="card">
                <div class="task-item <?= $r['task_status'] == 'close' ? 'done' : ''?>">
                    <div>
                    <input type="checkbox" onclick="window.location.href= '?done=<?=$r['task_id']?>&status=<?=$r['task_status']?>'" <?= $r['task_status'] == 'close' ? 'checked' : ''?>>                        
                    <span><?= $r['task_label']?></span>
                    </div>

                    <div>
                        <a href="edit.php?id=<?= $r['task_id']?>" class="edit-task"><i class='bx bx-edit-alt' title="Edit"></i></a>
                        <a href="?delete=<?= $r['task_id']?>" class="delete-task" title="Remove" onclick="return confirm('Seriously?')"><i class='bx bx-trash' ></i></a>
                    </div>
                </div>
            </div>
        <?php  }} else { ?>
            <div>No data yet! 🤯 </div>
        <?php } ?>
           
        </div>
    </div>
</body>
</html>