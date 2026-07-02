<?php

require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();

$user = new User($conn);

$id = $_GET['id'];

$data = $user->getById($id);

if($_POST){

    $user->update($id,$_POST);

    header("Location:index.php");
}

$roles = $conn->query("SELECT * FROM roles");

?>

<form method="POST">

<input
type="text"
name="nama"
value="<?= $data['nama'] ?>"
required>

<input
type="email"
name="email"
value="<?= $data['email'] ?>"
required>

<input
type="password"
name="password"
placeholder="Kosongkan jika tidak diubah">

<select name="role_id">

<?php foreach($roles as $r): ?>

<option
value="<?= $r['id'] ?>"
<?= $r['id']==$data['role_id']?'selected':'' ?>>

<?= $r['nama_role'] ?>

</option>

<?php endforeach; ?>

</select>

<button type="submit">
Update
</button>

</form>