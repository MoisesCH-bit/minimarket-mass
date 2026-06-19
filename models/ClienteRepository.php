<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/Cliente.php';

class ClienteRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexion();
    }

    public function obtenerTodos(): array {
        $stmt = $this->pdo->query(
            "SELECT * FROM clientes WHERE activo = 1 ORDER BY apellidos ASC"
        );
        $filas = $stmt->fetchAll();
        $resultado = [];
        foreach ($filas as $f) {
            $resultado[] = new Cliente(
                $f['dni'], $f['nombres'], $f['apellidos'],
                $f['telefono'] ?? '', $f['email'] ?? '', $f['tipo_cliente']
            );
        }
        return $resultado;
    }

    public function buscarPorDni(string $dni): ?Cliente {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM clientes WHERE dni = ? AND activo = 1"
        );
        $stmt->execute([$dni]);
        $f = $stmt->fetch();
        if (!$f) return null;
        return new Cliente(
            $f['dni'], $f['nombres'], $f['apellidos'],
            $f['telefono'] ?? '', $f['email'] ?? '', $f['tipo_cliente']
        );
    }

    public function crear(array $datos): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO clientes (dni, nombres, apellidos, telefono, email, tipo_cliente)
             VALUES (:dni, :nombres, :apellidos, :telefono, :email, :tipo_cliente)"
        );
        return $stmt->execute([
            'dni'          => $datos['dni'],
            'nombres'      => $datos['nombres'],
            'apellidos'    => $datos['apellidos'],
            'telefono'     => $datos['telefono'] ?? '',
            'email'        => $datos['email'] ?? '',
            'tipo_cliente' => $datos['tipo_cliente'] ?? 'regular',
        ]);
    }

    public function eliminar(string $dni): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE clientes SET activo = 0 WHERE dni = ?"
        );
        return $stmt->execute([$dni]);
    }
    public function actualizar(string $dni, array $datos): bool {
    $stmt = $this->pdo->prepare(
        "UPDATE clientes
         SET nombres = :nombres, apellidos = :apellidos,
             telefono = :telefono, email = :email
         WHERE dni = :dni"
    );
    return $stmt->execute([
        'nombres'   => $datos['nombres'],
        'apellidos' => $datos['apellidos'],
        'telefono'  => $datos['telefono'] ?? '',
        'email'     => $datos['email'] ?? '',
        'dni'       => $dni,
    ]);
}
public function contarActivos(): int {
    try {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM clientes WHERE activo = 1");
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('[ClienteRepository::contarActivos] ' . $e->getMessage());
        return 0;
    }
}

public function obtenerPagina(int $limite, int $offset): array {
    try {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM clientes WHERE activo = 1
             ORDER BY apellidos ASC
             LIMIT :limite OFFSET :offset"
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = [];
        foreach ($stmt->fetchAll() as $f) {
            $resultado[] = new Cliente(
                $f['dni'], $f['nombres'], $f['apellidos'],
                $f['telefono'] ?? '', $f['email'] ?? '', $f['tipo_cliente']
            );
        }
        return $resultado;
    } catch (PDOException $e) {
        error_log('[ClienteRepository::obtenerPagina] ' . $e->getMessage());
        return [];
    }
}
}