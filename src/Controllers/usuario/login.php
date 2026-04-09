<?php

namespace Controllers\usuario;

use Controllers\PublicController;

class login extends PublicController {

    public function run(): void {

        $this->viewName = "usuario/login";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $usuarioModel = new \UsuarioModel();

            $email = $_POST['email'];
            $password = $_POST['password'];

            $usuario = $usuarioModel->obtenerUsuarioPorEmail($email);

            if ($usuario && password_verify($password, $usuario->password)) {

                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nombre'] = $usuario->nombre;
                $_SESSION['usuario_rol'] = $usuario->role;

                echo "Login correcto";

            } else {
                echo "Correo o contraseña incorrectos";
            }
        }
    }
}