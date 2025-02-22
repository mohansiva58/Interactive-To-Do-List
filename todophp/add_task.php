<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];

    $sql = "INSERT INTO tasks (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Task</title>
    <style>
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

/* Glassmorphism Effect */
.container {
    background: rgba(255, 255, 255, 0.1); /* Semi-transparent */
    backdrop-filter: blur(10px); /* Glass Effect */
    -webkit-backdrop-filter: blur(10px);
    color: white;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
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
    background: rgba(255, 255, 255, 0.4);
    color: black;
    font-size: 16px;
}

input::placeholder, textarea::placeholder {
    color: black;
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
        <h2>Add Task</h2>
        <form action="add_task.php" method="POST">
            <input type="text" name="title" placeholder="Task Title" required>
            <textarea name="description" placeholder="Task Description"></textarea>
            <button type="submit">Add Task</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
