<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

include('connection.php');
if (isset($_GET['delete'])) {
    $task_id = intval($_GET['delete']); 
    $conn->query("DELETE FROM list WHERE id = $task_id");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="indexs.css">
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
            <h1 class="h3">Keep things in check!!</h1>
        </header>
        <section class="content">
            <h2 class="h4 mb-4">All Tasks</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Task</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `list` ORDER BY date DESC"; 
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusText = ($row['Status'] == 1) ? "Completed ✅" : "Pending ⏳";
                                echo "<tr>
                                        <td>{$row['ID']}</td>
                                        <td>{$row['Task']}</td>
                                        <td>{$row['Date']}</td>
                                        <td>{$row['Status']}</td>
                                        <td>
                                            <a href='updatetask.php?ID={$row['ID']}' class='btn btn-sm btn-warning'>Update</a>
                                            <a href='index.php?delete={$row['ID']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No tasks found</td></tr>";
                        }
                        ?> 
                    </tbody>
                </table>
            </div>
            <a href="task.php" class="btn btn-primary">Add New Task</a>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>