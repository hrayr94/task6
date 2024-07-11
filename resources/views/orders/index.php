<?php require_once __DIR__ . "/../layout/header.php"; ?>

<div class="container">
    <h1>Orders</h1>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Customer ID</th>
            <th>Total Price</th>
            <th>Created At</th>
            <th>Actions</th> <!-- New column for actions -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['customer_id'] ?></td>
                <td><?= $order['total_price'] ?></td>
                <td><?= $order['created_at'] ?></td>
                <td>
                    <a href="/orders/details/<?= $order['customer_id'] ?>" class="btn btn-primary">Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
