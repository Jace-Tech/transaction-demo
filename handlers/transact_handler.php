<?php
require("../config/db.php");
require("../utils/helpers.php");
require("../store/all.php");

// DEPOSIT LOGIC
if(isset($_POST['deposit'])) {
  $user_id = $_POST["user"];
  $amount = $_POST['amount'];
  try {
    // GET USERS DETAILS
    $user_details = get_one_user($user_id);

    // CALCULATE NEW BALANCE
    $new_balance = (float) $amount + (float) $user_details['balance'];

    // UPDATE USERS BALANCE
    // TODO: YOU CAN MAKE THIS A FUNCTION
    $query = "UPDATE user SET balance = :balance WHERE id = :id";
    $result = $connect->prepare($query);
    $result->execute(["balance" => $new_balance, "id" => $user_id]);
    if(!$result->rowCount()) throw new Exception("Failed to deposit");

    // CREATE TRANSACTION 
    // TODO: YOU CAN MAKE THIS A FUNCTION
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`) VALUES (:user, :type, :amount)";
    $result = $connect->prepare($query);
    $result->execute([  
      "user" => $user_id,
      "type" => "credit",
      "amount" => $amount
    ]);
    if(!$result->rowCount()) throw new Exception("Failed to create transaction");

    setAlert("Balance updated!");
    redirect("../deposit.php");
  }
  catch(Exception $err) {
    // CREATE TRANSACTION 
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`, `status`) VALUES (:user, :type, :amount, :status)";
    $result = $connect->prepare($query);
    $result->execute([
      "user" => $user_id,
      "type" => "credit",
      "amount" => $amount,
      "status" => 0,
    ]);
    setAlert("Failed to create user");
    redirect("../deposit.php");
  }
}


// TRANSFER LOGIC
if(isset($_POST['transfer'])) {
  $from = $_POST["from"];
  $to = $_POST["to"];
  $amount = (float) $_POST['amount'];
  try {

    // ------------------- FOR SENDER -----------------------
    // GET FROM (USER) DETAILS
    $from_details = get_one_user($from);

    // CHECK IF BALANCE IS ENOUGH TO TRANSFER
    if($amount > (float) $from_details["balance"]) throw new Exception("Insufficient Funds");

    // MINUS AMOUNT FROM BALANCE
    $new_balance_from = (float) $from_details['balance'] - $amount;

    // UPDATE FROM BALANCE
    $query = "UPDATE user SET balance = :balance WHERE id = :id";
    $result = $connect->prepare($query);
    $result->execute(["balance" => $new_balance_from, "id" => $from]);

    if(!$result->rowCount()) throw new Exception("Failed to transfer");

     // CREATE TRANSACTION 
     $query = "INSERT INTO `transactions`(`user`, `type`, `amount`) VALUES (:user, :type, :amount)";
     $result = $connect->prepare($query);
     $result->execute([
       "user" => $from,
       "type" => "debit",
       "amount" => $amount,
     ]);
    // -------------------END FOR SENDER -----------------------


    // ------------------- FOR RECIEVER -----------------------
    // GET TO (USER) DETAILS
    $to_details = get_one_user($to);

    // ADD AMOUNT TO BALANCE
    $new_balance_to = (float) $to_details['balance'] + $amount;

    // CALCULATE NEW BALANCE
    $new_balance = (float) $amount + (float) $user_details['balance'];

    // UPDATE TO BALANCE
    $query = "UPDATE user SET balance = :balance WHERE id = :id";
    $result = $connect->prepare($query);
    $result->execute(["balance" => $new_balance_to, "id" => $to]);

    if(!$result->rowCount()) throw new Exception("Failed to transfer");

    // CREATE TRANSACTION 
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`) VALUES (:user, :type, :amount)";
    $result = $connect->prepare($query);
    $result->execute([
      "user" => $to,
      "type" => "credit",
      "amount" => $amount,
    ]);
    // -------------------END FOR RECIEVER -----------------------

    setAlert("Transfer completed!");
    redirect("../transfer.php");
  }
  catch(Exception $err) {
    // CREATE TRANSACTION 
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`, `status`) VALUES (:user, :type, :amount, :status)";
    $result = $connect->prepare($query);
    $result->execute([
      "user" => $from,
      "type" => "debit",
      "amount" => $amount,
      "status" => 0
    ]);
    setAlert($err->getMessage(), "error");
    redirect("../transfer.php");
  }
}


// WITHDRAW LOGIC
if(isset($_POST['withdraw'])) {
  $user_id = $_POST["user"];
  $amount = $_POST['amount'];
  try {

    // GET USERS DETAILS
    $user_details = get_one_user($user_id);

    // CHECK IF BALANCE IS ENOUGH TO WITHDRAW
    if($amount > (float) $user_details["balance"]) throw new Exception("Insufficient Funds");

    // CALCULATE NEW BALANCE
    $new_balance = (float) $user_details['balance'] - (float) $amount;

    // UPDATE USERS BALANCE
    $query = "UPDATE user SET balance = :balance WHERE id = :id";
    $result = $connect->prepare($query);
    $result->execute(["balance" => $new_balance, "id" => $user_id]);
    if(!$result->rowCount()) throw new Exception("Failed to withdraw");

    // CREATE TRANSACTION 
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`) VALUES (:user, :type, :amount)";
    $result = $connect->prepare($query);
    $result->execute([
      "user" => $user_id,
      "type" => "debit",
      "amount" => $amount,
    ]);


    setAlert("Withdrawal completed!");
    redirect("../withdraw.php");
  }
  catch(Exception $err) {
    // CREATE TRANSACTION 
    $query = "INSERT INTO `transactions`(`user`, `type`, `amount`, `status`) VALUES (:user, :type, :amount, :status)";
    $result = $connect->prepare($query);
    $result->execute([
      "user" => $user_id,
      "type" => "debit",
      "amount" => $amount,
      "status" => 0
    ]);
    setAlert("Failed to create user");
    redirect("../withdraw.php");
  }
}