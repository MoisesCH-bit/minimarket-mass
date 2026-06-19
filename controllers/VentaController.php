<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/VentaRepository.php';

class VentaController {

    private VentaRepository $repo;

    public function __construct() {
        $this->repo = new VentaRepository();
    }

    // Muestra la pantalla de nueva venta
    public function nueva(): void {
        require __DIR__ . '/../views/ventas/nueva.php';
    }

    // AJAX: busca producto por código de barras
public function buscarProductoAjax(): void {
    $termino   = trim($_GET['codigo'] ?? '');
    $productos = $this->repo->buscarProductoPorCodigo($termino);

    header('Content-Type: application/json');
    echo json_encode($productos);
    exit;
}

    // AJAX: busca cliente por DNI
public function buscarClienteAjax(): void {
    $dni     = trim($_GET['dni'] ?? '');
    $cliente = $this->repo->buscarClientePorDni($dni);

    header('Content-Type: application/json');
    echo json_encode($cliente ?: ['error' => 'Cliente no encontrado']);
    exit;
}

    // Procesa y guarda la venta
    public function guardar(): void {
        $clienteId  = (int)   ($_POST['cliente_id']  ?? 0);
        $metodoPago = trim(   $_POST['metodo_pago']  ?? '');
        $itemsJson  = trim(   $_POST['items']        ?? '[]');
        $usuario    = $_SESSION['usuario'];

        $items = json_decode($itemsJson, true);

        if ($clienteId === 0 || empty($items) || $metodoPago === '') {
            header('Location: index.php?accion=nueva-venta&error=1');
            exit;
        }

        // Calcular totales
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['precio_unitario'] * $item['cantidad'];
        }
        $subtotal = round($subtotal, 2);
        $igv      = round($subtotal * 0.18, 2);
        $total    = round($subtotal + $igv, 2);

        $ventaData = [
            'numero_comprobante' => $this->repo->generarNumeroComprobante(),
            'cliente_id'         => $clienteId,
            'usuario_id'         => $usuario['id'],
            'subtotal'           => $subtotal,
            'igv'                => $igv,
            'total'              => $total,
            'metodo_pago'        => $metodoPago,
        ];

        $ventaId = $this->repo->guardar($ventaData, $items);

        if ($ventaId === 0) {
            header('Location: index.php?accion=nueva-venta&error=1');
            exit;
        }

        header('Location: index.php?accion=boleta-venta&id=' . $ventaId);
        exit;
    }

    // Muestra la boleta después de la venta
    public function boleta(): void {
        $id    = (int)($_GET['id'] ?? 0);
        $venta = $this->repo->obtenerConDetalle($id);

        if (!$venta) {
            header('Location: index.php?accion=nueva-venta');
            exit;
        }

        require __DIR__ . '/../views/ventas/boleta.php';
    }
}