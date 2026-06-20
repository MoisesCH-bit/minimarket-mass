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

    // ───────────── AUTH ─────────────
    case 'login':
        $auth->mostrarLogin();
        break;

    case 'procesar-login':
        $auth->procesarLogin();
        break;

    case 'logout':
        $auth->logout();
        break;

    // ───────────── PRODUCTOS ─────────────
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

    case 'eliminar-producto':
        requiereLogin();
        (new ProductoController())->eliminar();
        break;

    case 'buscar-producto-ajax':
        requiereLogin();
        (new ProductoController())->buscarAjax();
        break;

    // ───────────── CLIENTES ─────────────
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

    case 'editar-cliente':
        requiereLogin();
        (new ClienteController())->editar();
        break;

    case 'actualizar-cliente':
        requiereLogin();
        (new ClienteController())->actualizar();
        break;

    case 'eliminar-cliente':
        requiereLogin();
        (new ClienteController())->eliminar();
        break;

    // ───────────── VENTAS ─────────────
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

    // ───────────── REPORTES ─────────────
    case 'reporte-pdf':
        requiereLogin();
        (new ReporteController())->catalogoPdf();
        break;

    // ───────────── DEFAULT ─────────────
    case 'catalogo':
    default:
        requiereLogin();
        (new ProductoController())->listar();
        break;
}