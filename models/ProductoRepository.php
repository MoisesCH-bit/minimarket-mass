<?php
declare(strict_types=1);
require_once __DIR__ . '/Producto.php';

/**
 * Repositorio de productos del Minimarket Mass.
 *
 * SESIÓN 4: los datos están hardcoded en un array.
 * SESIÓN 5: cambiaremos SOLO este archivo para usar PDO + MySQL.
 *           El resto del sistema (Controller, View) NO se va a tocar.
 *
 * Esta clase encapsula el acceso a datos: cualquiera que necesite
 * productos llama a este Repository sin importarle de dónde vienen.
 */
class ProductoRepository {

    /**
     * Devuelve TODOS los productos del catálogo.
     * @return Producto[]  array de objetos Producto
     */
    public function obtenerTodos(): array {
        return [
            new Producto('INC500', 'Inca Kola 500ml',        3.50, 48),
            new Producto('GLO400', 'Gloria evaporada 400g',  3.80, 62),
            new Producto('COS750', 'Arroz Costeño 750g',     4.20, 35),
            new Producto('PIL500', 'Cerveza Pilsen 500ml',   5.50, 24),
            new Producto('CHO200', 'Chocolate Sublime 200g', 2.80, 50),
            new Producto('PAN100', 'Pan francés (100g)',     0.30, 200),
            new Producto('LEC1L',  'Leche Gloria 1L',        5.20, 40),
        ];
    }

    /**
     * Busca UN producto por su código.
     * Devuelve null si no existe.
     */
    public function buscarPorCodigo(string $codigo): ?Producto {
        foreach ($this->obtenerTodos() as $producto) {
            if ($producto->getCodigo() === $codigo) {
                return $producto;
            }
        }
        return null;
    }
}
?>