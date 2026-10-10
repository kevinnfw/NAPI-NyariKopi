```php
<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'coffee_app';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection successful to database: $db_name";
?>
```