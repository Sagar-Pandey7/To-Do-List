<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

include('connection.php');

$task_id = $_GET['ID'] ?? null;

if ($task_id) {
    $sql = "SELECT * FROM list WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if (!$task) {
        echo "<script>alert('Task not found'); window.location.href = 'index.php';</script>";
        exit();
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid Task ID'); window.location.href = 'index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_description = $_POST['task'] ?? '';
    $date = $_POST['date'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($task_description) && !empty($date) && !empty($status)) {
        $sql = "UPDATE list SET Task = ?, Date = ?, Status = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $task_description, $date, $status, $task_id);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="up.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Task Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">All Tasks</a>
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
    <div class="container mt-4">
        <h1 class="text-center mb-4">Update Task</h1>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Edit Task Details</h3>
                        <form method="POST" action="updatetask.php?ID=<?php echo htmlspecialchars($task_id); ?>">
                            <div class="mb-3">
                                <label for="task" class="form-label">Task Description</label>
                                <input type="text" class="form-control" id="task" name="task" value="<?php echo htmlspecialchars($task['Task']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($task['Date']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Pending" <?php echo ($task['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Completed" <?php echo ($task['Status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                    <option value="In Progress" <?php echo ($task['Status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

