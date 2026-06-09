<?php
// clases/Cliente.php

class Cliente {
    private string $nombre;
    private string $dni;
    private string $tipo; // regular, frecuente, vip

    public function __construct(string $nombre, string $dni, string $tipo) {
        $this->nombre = $nombre;
        $this->setDni($dni); // Validamos al asignar
        $this->tipo = strtolower($tipo);
    }

    // Encapsulación y validación de DNI 
    public function setDni(string $dni): void {
        if (strlen($dni) !== 8 || !is_numeric($dni)) {
            throw new Exception("ERROR: El DNI debe tener exactamente 8 digitos numericos.");
        }
        $this->dni = $dni;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDni(): string {
        return $this->dni;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    // Devuelve el porcentaje de descuento según el tipo de cliente
    public function getPorcentajeDescuento(): float {
        switch ($this->tipo) {
            case 'frecuente':
                return 0.02; // 2%
            case 'vip':
                return 0.05; // 5%
            case 'regular':
            default:
                return 0.00; // 0%
        }
    }
}