<?php
include 'config.php';

$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do List</title>
    <style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    background: url("bgg.jpg") no-repeat center center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 20px;
    color:black;
}

/* Glassmorphism Effect */
.container {
    background: rgba(255, 255, 255, 0.1); /* Transparent Glass Effect */
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: black;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    animation: slideUp 1s ease-in-out;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    color: black;
}

/* Buttons */
button {
    background: rgba(0, 123, 255, 0.8);
    color: black;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    transition: transform 0.3s ease-in-out, background 0.3s;
}

button:hover {
    transform: scale(1.1);
    background: rgba(0, 123, 255, 1);
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 100%;
        padding: 20px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }
}

/* Smooth Slide-Up Animation */
@keyframes slideUp {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

    </style>
</head>
<body>
    <div class="container">
        <h2>To-Do List</h2>
        <a href="add_task.php"><button>Add New Task</button></a>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo ucfirst($row["status"]); ?></td>
                <td>
                    <a href="complete_task.php?id=<?php echo $row['id']; ?>">
                        <button>Complete</button>
                    </a>
                    <a href="delete_task.php?id=<?php echo $row['id']; ?>">
                        <button style="background: red;">Delete</button>
                    </a>
                   
    <a href="edit_task.php?id=<?php echo $row['id']; ?>"><button style="background: #ffc107;">Edit</button></a>
   


                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
