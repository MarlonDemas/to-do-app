<?php
    // Intialize errors variable
    $errors = '';

    // Connect to database
    $db = mysqli_connect("localhost", "root", "", "db_tasks");

    // Test Connection
    if (mysqli_connect_errno()) {
        // Connection Failed
        echo mysqli_connect_errno();
    } 
    else {
        echo "Connection Successful";
    }

    // Insert a quote if submit button is clicked
    if (isset($_POST['submit'])) {
        if (empty($_POST['task'])) {
            $errors = "You must fill in the task";
        } else {
            $task = $_POST['task'];
            $sql_insert = "INSERT INTO tasks (task) VALUES ('$task')";
            mysqli_query($db,$sql_insert);
            header('Location: '. $_SERVER['PHP_SELF']);
        }
        
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
    </head>
    <body>
        <h1 class="title is-1 has-text-centered">To-do Application</h1>
        <hr>
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
                    <input type="date" name="date" class="input">
                </div>
                <label class="label">Time:</label>
                <div class="control">
                    <input type="time" name="time" class="input">
                </div>
            </div>
            <button type="submit" class="button is-info" name="submit">Submit</button>
        </form>
        <table class="table is-bordered">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Tasks</th>
                    <th style="width: 60px;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                // select all tasks if page is visited or refreshed
                $tasks = mysqli_query($db, "SELECT * FROM tasks");

                $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td class="task"> <?php echo $row['task']; ?> </td>
                        <td class="delete"> 
                            <a href="index.php?del_task=<?php echo $row['id'] ?>">x</a> 
                        </td>
                    </tr>
                <?php $i++; } ?>	
            </tbody>
        </table>
    </body>
</html>