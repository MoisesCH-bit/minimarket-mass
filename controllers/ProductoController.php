<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/ProductoRepository.php';

class ProductoController {

    private ProductoRepository $repo;

    public function __construct() {
        $this->repo = new ProductoRepository();
    }

public function listar(): void {
    $porPagina   = 10;
    $paginaActual = max(1, (int)($_GET['pagina'] ?? 1));
    $offset       = ($paginaActual - 1) * $porPagina;

    $total        = $this->repo->contarActivos();
    $totalPaginas = (int) ceil($total / $porPagina);
    $productos    = $this->repo->obtenerPagina($porPagina, $offset);

    require __DIR__ . '/../views/productos/lista.php';
}

    public function nuevo(): void {
        require __DIR__ . '/../views/productos/crear.php';
    }

    public function guardar(): void {
        $codigo    = trim($_POST['codigo'] ?? '');
        $nombre    = trim($_POST['nombre'] ?? '');
        $marca     = trim($_POST['marca'] ?? '');
        $categoria = (int)  ($_POST['categoria'] ?? 0);
        $precio    = (float)($_POST['precio'] ?? 0);
        $stock     = (int)  ($_POST['stock'] ?? 0);

        if ($codigo === '' || $nombre === '' || $precio <= 0) {
            $error = 'Completa código, nombre y un precio mayor a 0.';
            require __DIR__ . '/../views/productos/crear.php';
            return;
        }

        $this->repo->crear([
            'codigo' => $codigo, 'nombre' => $nombre, 'marca' => $marca,
            'categoria' => $categoria, 'precio' => $precio, 'stock' => $stock,
        ]);

        header('Location: index.php?accion=catalogo');
        exit;
    }

    public function editar(): void {
        $codigo   = trim($_GET['codigo'] ?? '');
        $producto = $this->repo->buscarPorCodigo($codigo);

        if ($producto === null) {
            header('Location: index.php?accion=catalogo');
            exit;
        }

        require __DIR__ . '/../views/productos/editar.php';
    }

    public function actualizar(): void {
        $codigo = trim($_POST['codigo'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $stock  = (int)  ($_POST['stock'] ?? 0);

        if ($nombre === '' || $precio <= 0) {
            $error    = 'Nombre y precio son obligatorios.';
            $producto = $this->repo->buscarPorCodigo($codigo);
            require __DIR__ . '/../views/productos/editar.php';
            return;
        }

        $this->repo->actualizar($codigo, [
            'nombre' => $nombre,
            'precio' => $precio,
            'stock'  => $stock,
        ]);

        header('Location: index.php?accion=catalogo');
        exit;
    }

    public function eliminar(): void {
        $codigo = trim($_GET['codigo'] ?? '');

        if ($codigo !== '') {
            $this->repo->eliminar($codigo);
        }

        header('Location: index.php?accion=catalogo');
        exit;
    }
    public function buscarAjax(): void {
    $termino = trim($_GET['q'] ?? '');

    if ($termino === '') {
        $productos = [];
    } else {
        $productos = $this->repo->buscarPorNombreOCodigo($termino);
    }

    header('Content-Type: application/json');
    echo json_encode(array_map(function($p) {
        return [
            'codigo'      => $p->getCodigo(),
            'nombre'      => $p->getNombre(),
            'precio'      => $p->getPrecio(),
            'precioConIgv'=> $p->precioConIGV(),
            'stock'       => $p->getStock(),
        ];
    }, $productos));
    exit;
}
}