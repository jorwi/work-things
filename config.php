<?php
  header("strict-transport-security: max-age=31536000; includeSubDomains; preload");
  header("Content-Security-Policy: default-src * 'self' fonts.googleapis.com script-src 'unsafe-inline'");

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  $server = "127.0.0.1";

  switch (basename($_SERVER['PHP_SELF'])):
     case 'bookmarks.php';
      $username = "bookmarks";
      $password = "";
      $db = "bookmarks";
      $title = "Managed bookmarks";
     break;
     case 'shared-mailbox.php';
      $db = null;
      $title = "Shared mailbox";
    break;
    case 'upn.php':
      $title = "Update UPN";
    break;
  endswitch;

  if (isset($db)) {
    try {
      $sql = new PDO("mysql:host=$server;db=$db", $username, $password);
      $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql->query("USE $db");
    } catch(PDOException $e) { echo "Connecton failed: " . $e->getMessage(); }
  }
?>