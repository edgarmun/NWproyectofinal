<?php

class UsuarioModel extends Model {

    public function guardarUsuario($datos) {

        $this->db->query("INSERT INTO users (nombre, apellido, email, password, role, estado, created_at)
                          VALUES (:nombre, :apellido, :email, :password, :role, 1, NOW())");

        $this->db->bind(':nombre', $datos['nombre']);
        $this->db->bind(':apellido', $datos['apellido']);
        $this->db->bind(':email', $datos['email']);
        $this->db->bind(':password', $datos['password']);
        $this->db->bind(':role', $datos['role']);

        return $this->db->execute();
    }

    public function obtenerUsuarioPorEmail($email) {

        $this->db->query("SELECT * FROM users WHERE email = :email LIMIT 1");
        $this->db->bind(':email', $email);

        return $this->db->single();
    }
}