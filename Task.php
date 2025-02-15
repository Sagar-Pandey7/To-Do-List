<?php
include 'connection.php';
if(isset($_POST['submit'])){
    $task=$_POST['task'];
    $date=$_POST['date'];
    $status=$_POST['status'];

    $sql="insert into `list`(task,date,status)
    values('$task','$date','$status')";
    $result=mysqli_query($conn,$sql);
    if($result){
        header('location:index.php');
    }
    else{
        die(mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><i class='bx bxl-deezer'></i>To-Do List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">All Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="task.php">New Task</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?logout=true">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">New Task</h1>
        </header>
        <section class="content">
            <h2 class="h4 mb-4">Create a New Task</h2>
            <form method="POST" action="task.php" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="task" class="form-label">Task Description</label>
                    <input type="text" class="form-control" id="task" name="task" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="PENDING">PENDING</option>
                        <option value="COMPLETED">COMPLETED</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Add Task</button>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>