<?php

namespace Controllers\usuario;

use Controllers\PublicController;

class registro extends PublicController {

    public function run(): void {

        $this->viewName = "usuario/registro";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $usuarioModel = new \UsuarioModel();

            $datos = [
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'confirmar' => $_POST['confirmar'],
                'role' => 'cliente'
            ];

            if ($datos['password'] != $datos['confirmar']) {
                echo "Las contraseñas no coinciden";
                return;
            }

            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);

            if ($usuarioModel->guardarUsuario($datos)) {
                echo "Usuario registrado";
            } else {
                echo "Error al registrar";
            }
        }
    }
}