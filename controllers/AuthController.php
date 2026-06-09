<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/UsuarioRepository.php';
 
class AuthController {
 
    public function mostrarLogin(string $error = ''): void {
        require __DIR__ . '/../views/auth/login.php';
    }
 
    public function procesarLogin(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
 
        if (!isset($_SESSION['intentos_fallidos'])) {
            $_SESSION['intentos_fallidos'] = 0;
        }
 
        if ($_SESSION['intentos_fallidos'] >= 3) {
            $this->mostrarLogin('Demasiados intentos. Reinicia el navegador para continuar.');
            return;
        }
 
        if ($username === '' || $password === '') {
            $this->mostrarLogin('Completa usuario y contraseña.');
            return;
        }
 
        $repo    = new UsuarioRepository();
        $usuario = $repo->buscarPorUsername($username);
 
        if ($usuario === null || !$usuario->verificarPassword($password)) {
            $_SESSION['intentos_fallidos']++;
            $restantes = 3 - $_SESSION['intentos_fallidos'];
            $msg = $restantes > 0
                ? "Usuario o contraseña incorrectos. Intentos restantes: $restantes"
                : 'Demasiados intentos. Reinicia el navegador para continuar.';
            $this->mostrarLogin($msg);
            return;
        }
 
        // Parte B1: registrar acceso ANTES de redirigir
        $repo->registrarAcceso($usuario->getId());
 
        // Volver a buscar para obtener el ultimo_acceso que acabamos de escribir
        $usuarioActualizado = $repo->buscarPorUsername($username);
 
        $_SESSION['intentos_fallidos'] = 0;
        $_SESSION['usuario'] = [
            'id'            => $usuario->getId(),
            'username'      => $usuario->getUsername(),
            'nombre'        => $usuario->getNombreCompleto(),
            'rol'           => $usuario->getRol(),
            'tienda'        => $usuario->getTienda(),
            'ultimo_acceso' => $usuarioActualizado?->getUltimoAcceso(),
        ];
 
        header('Location: index.php?accion=catalogo');
        exit;
    }
 
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?accion=login');
        exit;
    }
}