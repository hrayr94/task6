<?php require_once __DIR__ . "/../layout/header.php"; ?>

<div class="container">
    <h1>Order Details</h1>
    <div>
        <h3>Customer Information:</h3>
        <ul>
            <li><strong>ID:</strong> <?= $customer['id'] ?></li>
            <li><strong>First Name:</strong> <?= $customer['first_name'] ?></li>
            <li><strong>Last Name:</strong> <?= $customer['last_name'] ?></li>
            <li><strong>Phone Number:</strong> <?= $customer['phone_number'] ?></li>
            <li><strong>Address:</strong> <?= $customer['address'] ?></li>
        </ul>
    </div>
</div>

</body>
</html>
