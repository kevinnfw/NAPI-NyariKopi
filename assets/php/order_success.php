<?php
session_start();
if (!isset($_SESSION['customer_username'])) {
    header('Location: ../php/customer_login.php');
    exit;
}
$username = $_SESSION['customer_username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0d3a2;
            color: #3a2e2e;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background-color: #fff6e1;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
            font-size: 1.1rem;
        }

        .menu-details {
            margin: 20px 0;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #3a2e2e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .button:hover {
            background-color: #d79805;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Success!</h1>
        <p>Welcome back, <b><?= htmlspecialchars($username); ?></b>!</p>
        <div class="menu-details">
            <p id="menu-name">...</p>
            <p id="menu-price">...</p>
        </div>
        <p>Your coffee order has been placed successfully.</p>
        <button class="button" onclick="proceedToPayment()">Proceed to Payment</button>
        <button class="button" onclick="window.location.href='../index.html'">Back to Home</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectedMenu = JSON.parse(localStorage.getItem('selectedMenu'));
            if (selectedMenu) {
                document.getElementById('menu-name').textContent = `Menu: ${selectedMenu.name}`;
                document.getElementById('menu-price').textContent = `Price: ${selectedMenu.price}K`;
            }
        });

        function proceedToPayment() {
            const selectedMenu = JSON.parse(localStorage.getItem('selectedMenu'));
            if (!selectedMenu) {
                alert('No menu selected. Please go back and select a menu.');
                return;
            }

            fetch('../php/save_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(selectedMenu),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order saved successfully!');
                    localStorage.removeItem('selectedMenu');
                    window.location.href = 'payment.php';
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>
