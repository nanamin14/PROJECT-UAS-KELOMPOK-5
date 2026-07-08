<?php
require '../config/Database.php';
require '../classes/User.php';

$db = new Database();
$conn = $db->connect();
$user = new User($conn);

$id = $_GET['id'] ?? null;
$data = $user->getById($id);

if ($_POST) {
    $user->update($id, $_POST);
    header("Location: index.php");
    exit; 
}

$roles = $conn->query("SELECT * FROM roles");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            padding: 40px !important;
        }
        .btn-kembali {
            background-color: #6c757d;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 15px;
            border: none;
        }
        .btn-kembali:hover {
            background-color: #5a6268;
            color: white;
        }
        .btn-simpan {
            background-color: #4461f2;
            color: white;
            border-radius: 8px;
            padding: 12px 28px;
            border: none;
            font-size: 16px;
        }
        .btn-simpan:hover {
            background-color: #324bc7;
            color: white;
        }
        .form-label {
            font-weight: 600;
            color: #212529;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
            color: #495057;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4461f2;
            box-shadow: 0 0 0 0.2rem rgba(68, 97, 242, 0.25);
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="card card-custom">
                <div class="mb-4">
                    <a href="index.php" class="btn btn-kembali text-decoration-none">← Kembali</a>
                </div>

                <h1 class="fw-bold mb-4" style="font-size: 32px; color: #212529;">Edit User</h1>

                <form method="POST">
                    
                    <div class="mb-4">
                        <label for="nama" class="form-label">Nama</label>
                        <input 
                            type="text" 
                            id="nama"
                            name="nama" 
                            class="form-control"
                            placeholder="Masukkan nama..."
                            value="<?= htmlspecialchars($data['nama'] ?? '') ?>" 
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            class="form-control"
                            placeholder="Masukkan email..."
                            value="<?= htmlspecialchars($data['email'] ?? '') ?>" 
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-control"
                            placeholder="Kosongkan jika tidak diubah"
                        >
                        <div class="form-text text-muted mt-1" style="font-size: 13px;">
                            *Biarkan kosong jika tidak ingin mengganti password user.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="role_id" class="form-label">Role</label>
                        <select id="role_id" name="role_id" class="form-select" required>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>" <?= ($r['id'] == $data['role_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['nama_role']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-simpan fw-semibold">Simpan Perubahan</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>