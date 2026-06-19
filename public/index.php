<?php
declare(strict_types=1);

// La sesión debe arrancar ANTES de cualquier salida al navegador.
session_start();

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/ReporteController.php';

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

    case 'nuevo-producto':
        requiereLogin();
        (new ProductoController())->nuevo();
        break;

    case 'guardar-producto':
        requiereLogin();
        (new ProductoController())->guardar();
        break;

    case 'editar-producto':
        requiereLogin();
        (new ProductoController())->editar();
        break;

    case 'actualizar-producto':
        requiereLogin();
        (new ProductoController())->actualizar();
        break;
    case 'reporte-pdf':
        requiereLogin();
        (new ReporteController())->catalogoPdf();
        break;
    case 'eliminar-producto':
        requiereLogin();
        (new ProductoController())->eliminar();
        break;
    case 'catalogo':
    default:
        requiereLogin();                      // sin sesión → manda al login
        (new ProductoController())->listar(); // ← llama al método REAL del controller
        break;
    case 'buscar-producto-ajax':
    requiereLogin();
    (new ProductoController())->buscarAjax();
    break;
}