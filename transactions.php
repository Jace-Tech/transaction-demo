<?php require("./config/db.php"); ?>
<?php require_once("./store/all.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users FORM</title>
</head>
<body>
  

  <?php include("./addons/links.php"); ?>
  <?php include("./addons/alert.php"); ?>
  <div>
    <h3>Transactions</h3>
    <table border="1" cellpadding="10">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Amount</th>
          <th>Type</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach(get_transactions() as $transaction): ?>
          <tr>
            <td><?= $transaction['id'] ?></td>
            <td><?= get_one_user($transaction['user'])['name']; ?></td>
            <td>$<?= number_format($transaction['amount']) ?></td>
            <td><?= $transaction['type'] ?></td>
            <td><?= $transaction['status'] == "1" ? "success" : "failed"; ?></td>
            <td><?= date("d M, Y - H:i:s a", strtotime($transaction['date'])); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>