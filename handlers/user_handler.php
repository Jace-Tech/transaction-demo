<?php
require("../config/db.php");
require("../utils/helpers.php");

if(isset($_POST['create'])) {
  try {
    $name = $_POST["name"];
  
    $query = "INSERT INTO user(name) VALUES (:name)";
    $result = $connect->prepare($query);
    $result->execute(["name" => $name]);

    if(!$result->rowCount()) throw new Exception("Failed to create");
    setAlert("User Created!");
    redirect("../");
  }
  catch(Exception $err) {
    setAlert($err->getMessage(), "error");
    redirect("../");
  }

}