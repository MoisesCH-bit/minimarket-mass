<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/conexion.php';

class VentaRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConexion();
    }

    public function guardar(array $venta, array $items): int {
        try {
            $this->pdo->beginTransaction();

            // 1. Insertar la venta
            $stmt = $this->pdo->prepare(
                "INSERT INTO ventas (numero_comprobante, cliente_id, usuario_id,
                 subtotal, igv, total, metodo_pago)
                 VALUES (:comprobante, :cliente_id, :usuario_id,
                 :subtotal, :igv, :total, :metodo_pago)"
            );
            $stmt->execute([
                ':comprobante'  => $venta['numero_comprobante'],
                ':cliente_id'   => $venta['cliente_id'],
                ':usuario_id'   => $venta['usuario_id'],
                ':subtotal'     => $venta['subtotal'],
                ':igv'          => $venta['igv'],
                ':total'        => $venta['total'],
                ':metodo_pago'  => $venta['metodo_pago'],
            ]);

            $ventaId = (int) $this->pdo->lastInsertId();

            // 2. Insertar cada item y descontar stock
            $stmtDetalle = $this->pdo->prepare(
                "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario, subtotal)
                 VALUES (:venta_id, :producto_id, :cantidad, :precio, :subtotal)"
            );
            $stmtStock = $this->pdo->prepare(
                "UPDATE productos SET stock = stock - :cantidad WHERE id = :id"
            );

            foreach ($items as $item) {
                $stmtDetalle->execute([
                    ':venta_id'   => $ventaId,
                    ':producto_id'=> $item['producto_id'],
                    ':cantidad'   => $item['cantidad'],
                    ':precio'     => $item['precio_unitario'],
                    ':subtotal'   => $item['subtotal'],
                ]);
                $stmtStock->execute([
                    ':cantidad' => $item['cantidad'],
                    ':id'       => $item['producto_id'],
                ]);
            }

            $this->pdo->commit();
            return $ventaId;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('[VentaRepository::guardar] ' . $e->getMessage());
            return 0;
        }
    }

    public function obtenerConDetalle(int $ventaId): ?array {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT v.*, c.nombres, c.apellidos, c.dni,
                        u.nombres AS cajero_nombres, u.apellidos AS cajero_apellidos
                 FROM ventas v
                 LEFT JOIN clientes c ON c.id = v.cliente_id
                 JOIN usuarios u ON u.id = v.usuario_id
                 WHERE v.id = :id"
            );
            $stmt->execute([':id' => $ventaId]);
            $venta = $stmt->fetch();
            if (!$venta) return null;

            $stmtItems = $this->pdo->prepare(
                "SELECT d.*, p.nombre, p.codigo_barras
                 FROM detalle_ventas d
                 JOIN productos p ON p.id = d.producto_id
                 WHERE d.venta_id = :id"
            );
            $stmtItems->execute([':id' => $ventaId]);
            $venta['items'] = $stmtItems->fetchAll();

            return $venta;

        } catch (PDOException $e) {
            error_log('[VentaRepository::obtenerConDetalle] ' . $e->getMessage());
            return null;
        }
    }

public function buscarProductoPorCodigo(string $termino): array {
    try {
        $stmt = $this->pdo->prepare(
            "SELECT id, codigo_barras, nombre, precio, stock
             FROM productos
             WHERE activo = 1
             AND (codigo_barras LIKE :termino1 OR nombre LIKE :termino2)
             ORDER BY nombre
             LIMIT 8"
        );
        $stmt->execute([
            ':termino1' => $termino . '%',
            ':termino2' => '%' . $termino . '%',
        ]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('[VentaRepository::buscarProductoPorCodigo] ' . $e->getMessage());
        return [];
    }
}

public function buscarClientePorDni(string $dni): ?array {
    try {
        $stmt = $this->pdo->prepare(
            "SELECT id, dni, nombres, apellidos, tipo_cliente
             FROM clientes WHERE dni LIKE :dni AND activo = 1
             LIMIT 1"
        );
        $stmt->execute([':dni' => $dni . '%']);
        $fila = $stmt->fetch();
        return $fila ?: null;
    } catch (PDOException $e) {
        error_log('[VentaRepository::buscarClientePorDni] ' . $e->getMessage());
        return null;
    }
}

    public function generarNumeroComprobante(): string {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ventas");
        $total = (int) $stmt->fetchColumn();
        return 'B001-' . str_pad((string)($total + 1), 6, '0', STR_PAD_LEFT);
    }
}