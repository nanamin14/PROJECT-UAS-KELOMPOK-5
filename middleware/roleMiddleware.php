<?php

class RoleMiddleware
{
    public static function check($roles)
    {
        if (
            !in_array(
                $_SESSION['role'],
                $roles
            )
        ) {
            die("Akses ditolak");
        }
    }
}
