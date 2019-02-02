<?php
    // Intialize errors variable
    $errors = '';

    // Connect to database
    $db = mysqli_connect("localhost", "root", "", "db_todo");

    // Insert a quote if submit button is clicked
    if (isset($_POST['submit'])) {
        if (empty($_POST['task'])) {
            $errors = "You must fill in the task";
        } else {
            $task = $_POST['task'];
            $date = $_POST['myDate'];
            $time = $_POST['myTime'];
            $sql_insert = "INSERT INTO tasks (task, myDate, myTime) VALUES ('$task', '$date', '$time')";
            mysqli_query($db, $sql_insert);
            header('Location: '. $_SERVER['PHP_SELF']);
        }       
    }
    // delete task
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];

        mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
        header('Location:'. $_SERVER['PHP_SELF']);
    }
?>

<!DOCTYPE html>
<html>  
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>To-do Application</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="hover.css">
    </head>
    <body>
        <h1 class="title is-1 has-text-centered">To-do Application</h1>
        <hr>
        <section class="section">
            <div class="container">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" class="form" method="post">
                    <?php if(isset($errors)) { ?>
                        <p> <?php echo $errors; ?></p>
                    <?php } ?>
                    <div class="field is-grouped">
                        <label class="label">Task name:</label>
                        <div class="control">
                            <input type="text" name="task" class="input">
                        </div>
                        <label class="label">Due Date:</label>
                        <div class="control">
                            <input type="date" name="myDate" class="input">
                        </div>
                        <label class="label">Time:</label>
                        <div class="control">
                            <input type="time" name="myTime" class="input">
                        </div>
                        <button type="submit" class="button is-info" name="submit">Add Task</button>
                    </div>
                </form>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <td>Task to be completed</td>
                            <td>Date</td>
                            <td>Time</td>
                            <td>Date Added</td>
                            <td>Delete</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    $tasks = mysqli_query($db, "SELECT * FROM tasks ORDER BY task");

                    $i = 1;
                    while ($row = mysqli_fetch_array($tasks)) {?>
                        <tr>
                            <td> <?php echo $row['task']; ?> </td>
                            <td> <?php echo $row['myDate']; ?> </td>
                            <td> <?php echo $row['myTime']; ?> </td>
                            <td> <?php echo $row['date_created']; ?> </td>
                            <td>
                                <a href="index.php?del_task=<?php echo $row['id'] ?>">
                                    <span class="icon hvr-icon-wobble-horizontal"><i class="fas fa-2x fa-trash-alt hvr-icon"></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </body>
</html>