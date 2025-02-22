<?php
include 'config.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM tasks WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if (!$task) {
        echo "Task not found!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];

    $sql = "UPDATE tasks SET title=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating task: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Task</title>
    <style>
        /* Reset Body */
body {
    font-family: Arial, sans-serif;
    background: url("bgg.jpg") no-repeat center center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 20px;
}

/* Glassmorphic Container */
.container {
    background: rgba(255, 255, 255, 0.1); /* Glass effect */
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: white;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    animation: fadeIn 1s ease-in-out;
}

/* Input & Textarea Styling */
input, textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: none;
    outline: none;
    background: rgba(255, 255, 255, 0.2);
    color: black;
    font-size: 16px;
    transition: all 0.3s;
}

input::placeholder, textarea::placeholder {
    color:black;
}

/* Input Focus Effect */
input:focus, textarea:focus {
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
}

/* Button Styling */
button {
    background: rgba(40, 167, 69, 0.8);
    color: white;
    padding: 12px 20px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    font-size: 16px;
}

button:hover {
    background: rgba(40, 167, 69, 1);
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 500px) {
    .container {
        width: 100%;
        padding: 20px;
    }
}

/* Fade-in Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>
        <form action="edit_task.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
            <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
            <textarea name="description"><?php echo $task['description']; ?></textarea>
            <button type="submit">Update Task</button>
        </form>
        <a href="index.php">Cancel</a>
    </div>
</body>
</html>
