<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requiereLogin(): void {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?accion=login');
        exit;
    }
}

function usuarioActual(): ?array {
    return $_SESSION['usuario'] ?? null;
}
function requiereRol(string $rol): void {
    requiereLogin();
    $usuario = usuarioActual();

    if ($usuario['rol'] !== $rol) {
        http_response_code(403);
        $nombre = htmlspecialchars($usuario['nombre']);
        $rolUsuario = htmlspecialchars($usuario['rol']);
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head><meta charset="UTF-8"><title>Acceso denegado</title>
        <style>
            body { font-family: sans-serif; display:flex; justify-content:center;
                   align-items:center; min-height:100vh; background:#f5f5f5; }
            .box { background:white; padding:2.5rem 3rem; border-radius:8px;
                   box-shadow:0 2px 12px rgba(0,0,0,.1); text-align:center; }
            h1 { color:#c0392b; } p { color:#555; }
            a { color:#2980b9; font-weight:bold; text-decoration:none; }
        </style></head>
        <body><div class="box">
            <h1>🚫 Acceso denegado</h1>
            <p>Hola <strong>$nombre</strong>, tu rol es <strong>$rolUsuario</strong>.<br>
               No tienes permiso para ver esta página.</p>
            <a href="index.php?accion=catalogo">← Volver al catálogo</a>
        </div></body></html>
        HTML;
        exit;
    }
}