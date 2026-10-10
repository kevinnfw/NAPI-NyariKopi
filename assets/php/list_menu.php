<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Menu</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Menu List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "coffee_app");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT * FROM menu ORDER BY created_at DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['price']) . "</td>
                        <td>
                            <a href='../php/manage_menu.php?action=edit&id=" . $row['id'] . "'>Edit</a> | 
                            <a href='../php/manage_menu.php?action=delete&id=" . $row['id'] . "'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No menu items found.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
