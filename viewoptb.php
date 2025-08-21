<?php
include 'database.php';


$result = $conn->query("SELECT `location`, `type`, `description` , `deadline` FROM opportunities ORDER BY posted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Opportunities</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            color: #fff;
            margin: 0 5px;
        }
        .edit-btn { background-color: #4caf50; }
        .delete-btn { background-color: #f44336; }
        .action-btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <h2>Posted Opportunities</h2>
    <table>
        <tr>
            
            <th>Location</th>
            <th>Type</th>
            <th>Description</th>
            <th>Deadline</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
           
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['type']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['deadline']) ?></td>
            <td>
                <button class="action-btn edit-btn">Edit</button>
                <button class="action-btn delete-btn">Delete</button>
            </td>
           
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
