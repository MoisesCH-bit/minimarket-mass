<?php
declare(strict_types=1);

// La sesión debe arrancar ANTES de cualquier salida al navegador.
session_start();

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

// Enrutamiento simple por ?accion=
$accion = $_GET['accion'] ?? 'catalogo';
$auth   = new AuthController();

switch ($accion) {

    case 'login':
        $auth->mostrarLogin();
        break;

    case 'procesar-login':
        $auth->procesarLogin();
        break;

    case 'logout':
        $auth->logout();
        break;

    case 'panel-admin':
        requiereRol('admin');
        $u = usuarioActual();
        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
              <title>Panel de administración</title>
              <style>body{font-family:sans-serif;padding:2rem;}
              h1{color:#0066B3;}</style></head><body>
              <h1>Panel de administración</h1>
              <p>Bienvenido, <strong>" . htmlspecialchars($u['nombre']) . "</strong>.</p>
              <a href='index.php?accion=catalogo'>← Volver al catálogo</a>
              </body></html>";
        break;

    case 'catalogo':
    default:
        requiereLogin();                      // sin sesión → manda al login
        (new ProductoController())->listar(); // ← llama al método REAL del controller
        break;
}