<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/ClienteRepository.php';

class ClienteController {

    private ClienteRepository $repo;

    public function __construct() {
        $this->repo = new ClienteRepository();
    }

public function listar(): void {
    $porPagina    = 10;
    $paginaActual = max(1, (int)($_GET['pagina'] ?? 1));
    $offset       = ($paginaActual - 1) * $porPagina;

    $total        = $this->repo->contarActivos();
    $totalPaginas = (int) ceil($total / $porPagina);
    $clientes     = $this->repo->obtenerPagina($porPagina, $offset);

    require __DIR__ . '/../views/clientes/lista.php';
}

    public function nuevo(): void {
        require __DIR__ . '/../views/clientes/crear.php';
    }

    public function guardar(): void {
        $dni       = trim($_POST['dni'] ?? '');
        $nombres   = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $telefono  = trim($_POST['telefono'] ?? '');
        $email     = trim($_POST['email'] ?? '');

        if ($dni === '' || $nombres === '' || $apellidos === '') {
            $error = 'DNI, nombres y apellidos son obligatorios.';
            require __DIR__ . '/../views/clientes/crear.php';
            return;
        }

        $this->repo->crear([
            'dni'       => $dni,
            'nombres'   => $nombres,
            'apellidos' => $apellidos,
            'telefono'  => $telefono,
            'email'     => $email,
        ]);

        header('Location: index.php?accion=clientes');
        exit;
    }

    public function eliminar(): void {
        $dni = $_GET['dni'] ?? '';
        if ($dni !== '') {
            $this->repo->eliminar($dni);
        }
        header('Location: index.php?accion=clientes');
        exit;
    }
    public function editar(): void {
    $dni = $_GET['dni'] ?? '';
    $cliente = $this->repo->buscarPorDni($dni);

    if (!$cliente) {
        header('Location: index.php?accion=clientes');
        exit;
    }

    require __DIR__ . '/../views/clientes/editar.php';
}

public function actualizar(): void {
    $dni       = trim($_POST['dni'] ?? '');
    $nombres   = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $email     = trim($_POST['email'] ?? '');

    if ($nombres === '' || $apellidos === '') {
        $cliente = $this->repo->buscarPorDni($dni);
        $error = 'Nombres y apellidos son obligatorios.';
        require __DIR__ . '/../views/clientes/editar.php';
        return;
    }

    $this->repo->actualizar($dni, [
        'nombres'   => $nombres,
        'apellidos' => $apellidos,
        'telefono'  => $telefono,
        'email'     => $email,
    ]);

    header('Location: index.php?accion=clientes');
    exit;
}
}