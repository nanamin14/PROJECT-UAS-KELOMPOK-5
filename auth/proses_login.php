<?php

session_start();

require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$data = $user->login(
    $_POST['email']
);

if (
    $data &&
    password_verify(
        $_POST['password'],
        $data['password']
    )
) {

    $_SESSION['user'] = $data['id'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['role'] = $data['nama_role'];

    header("Location: ../dashboard.php");

} else {

    echo "Email atau password salah";
}