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
  <form action="./handlers/user_handler.php" method="post">
    <div class="">
      <label for="name">Name</label>
      <input required type="text" id="name" name="name">
    </div>

    <div class="">
      <button name="create">Create user</button>
    </div>
  </form>


  <div>
    <h3>Users</h3>
    <table border="1" cellpadding="10">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Balance</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach(get_users() as $user): ?>
          <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td>$<?= number_format($user['balance']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>