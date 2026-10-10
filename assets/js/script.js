
// Driver functionalities

// Validate driver data
function validateDriver(driverId) {
    fetch('../php/validate_driver.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `driver_id=${driverId}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    })
    .catch(error => console.error('Error:', error));
}

// Fetch restock list
function fetchRestockList() {
    fetch('../php/restock_driver.php', { method: 'GET' })
    .then(response => response.json())
    .then(data => {
        console.log('Restock Items:', data);
        // Handle UI updates to show restock items
    })
    .catch(error => console.error('Error:', error));
}

// Activate driver location
function activateLocation(driverId) {
    fetch('../php/activate_location.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `driver_id=${driverId}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    })
    .catch(error => console.error('Error:', error));
}

// Update order status
function updateOrderStatus(orderId, status) {
    fetch('../php/manage_orders.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `order_id=${orderId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    })
    .catch(error => console.error('Error:', error));
}
