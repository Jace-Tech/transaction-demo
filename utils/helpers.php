<?php 
@session_start();

function setAlert($message, $type = "success") {
  $alert = json_encode([
    "message" => $message,
    "type" => $type
  ]);
  $_SESSION['APP_ALERT'] = $alert;
}

function decodeAlert() {
  if(!isset($_SESSION['APP_ALERT'])) return false;
  return json_decode($_SESSION['APP_ALERT'], true);
}


function redirect($path) {
  header("Location: $path");
}