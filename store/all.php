<?php  
function get_users(){
  global $connect;
  $result = $connect->query("SELECT * FROM user");
  $result->execute();
  return $result->fetchAll();
}

function get_transactions(){
  global $connect;
  $result = $connect->query("SELECT * FROM transactions");
  $result->execute();
  return $result->fetchAll();
}

function get_one_user($id){
  global $connect;
  $result = $connect->prepare("SELECT * FROM user WHERE id = ?");
  $result->execute([$id]);
  return $result->fetch();
}