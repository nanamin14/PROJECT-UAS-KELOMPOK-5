<?php

class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    public function login($email)
    {
        $sql = "
            SELECT users.*, roles.nama_role
            FROM users
            JOIN roles
            ON users.role_id = roles.id
            WHERE email = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getAll()
    {
        $sql = "
            SELECT users.*, roles.nama_role
            FROM users
            JOIN roles
            ON users.role_id = roles.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function create($data)
    {
        $sql = "
            INSERT INTO users
            (nama,email,password,role_id)
            VALUES (?,?,?,?)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['nama'],
            $data['email'],
            password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            ),
            $data['role_id']
        ]);
    }

   
    public function update($id,$data)
    {
        $sql = "
            UPDATE users
            SET nama=?,
                email=?,
                role_id=?
            WHERE id=?
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['nama'],
            $data['email'],
            $data['role_id'],
            $id
        ]);
    }

    
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }
}