<?php
// clases/Producto.php

class Producto {
    private string $nombre;
    private string $categoria; // bebidas, abarrotes, panaderia, etc.
    private float $precio;

    public function __construct(string $nombre, string $categoria, float $precio) {
        $this->nombre = $nombre;
        $this->categoria = strtolower($categoria);
        $this->precio = $precio;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getCategoria(): string {
        return $this->categoria;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    // Determina la tasa del IGV 
    public function getTasaIgv(): float {
        switch ($this->categoria) {
            case 'bebidas':
            case 'abarrotes':
                return 0.18; // 18%
            case 'panaderia':
                return 0.00; // Exento de IGV (0%)
            default:
                return 0.18; // Por defecto aplica tasa general
        }
    }
}