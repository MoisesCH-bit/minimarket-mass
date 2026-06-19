<?php
declare(strict_types=1);

// La sesión debe arrancar ANTES de cualquier salida al navegador.
session_start();

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/ReporteController.php';
require_once __DIR__ . '/../controllers/ClienteController.php';
require_once __DIR__ . '/../controllers/VentaController.php';

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
    case 'clientes':
    requiereLogin();
    (new ClienteController())->listar();
    break;

case 'nuevo-cliente':
    requiereLogin();
    (new ClienteController())->nuevo();
    break;

case 'guardar-cliente':
    requiereLogin();
    (new ClienteController())->guardar();
    break;

case 'eliminar-cliente':
    requiereLogin();
    (new ClienteController())->eliminar();
    break;

case 'editar-cliente':
    requiereLogin();
    (new ClienteController())->editar();
    break;

case 'actualizar-cliente':
    requiereLogin();
    (new ClienteController())->actualizar();
    break;

case 'nueva-venta':
    requiereLogin();
    (new VentaController())->nueva();
    break;

case 'buscar-producto-venta-ajax':
    requiereLogin();
    (new VentaController())->buscarProductoAjax();
    break;

case 'buscar-cliente-ajax':
    requiereLogin();
    (new VentaController())->buscarClienteAjax();
    break;

case 'guardar-venta':
    requiereLogin();
    (new VentaController())->guardar();
    break;

case 'boleta-venta':
    requiereLogin();
    (new VentaController())->boleta();
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