<?php

require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$id = $_GET['id'];

$user->delete($id);

header("Location:index.php");
exit;