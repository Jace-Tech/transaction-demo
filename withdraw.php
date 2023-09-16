<?php require("./config/db.php"); ?>
<?php require_once("./store/all.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transfer</title>
</head>

<body>


  <?php include("./addons/links.php"); ?>
  <?php include("./addons/alert.php"); ?>
  <form action="./handlers/transact_handler.php" method="post">
    <div class="">
      <label for="user">User</label>
      <select required name="user" id="user">
        <option value="" selected disabled>Select user</option>
        <?php foreach (get_users() as $user) : ?>
          <option value="<?= $user['id'] ?>">
            <?= $user['name'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="">
      <label for="amount">Amount</label>
      <input required type="number" id="amount" name="amount" inputmode="numeric">
    </div>

    <div class="">
      <button name="withdraw">Withdraw</button>
    </div>
  </form>
</body>

</html>