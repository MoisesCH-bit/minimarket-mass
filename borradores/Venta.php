<?php
// clases/Venta.php

class Venta {
    private Cliente $cliente;
    private array $items = []; // Almacenará pares de [ 'producto' => Objeto, 'cantidad' => Int ]
    private string $metodoPago;
    private string $fecha;

    public function __construct(Cliente $cliente, string $metodoPago) {
        $this->cliente = $cliente;
        $this->metodoPago = strtolower($metodoPago);
        $this->fecha = date('d/m/Y H:i:s');
    }

    // Agrega un producto a la venta con su respectiva cantidad
    public function agregarProducto(Producto $producto, int $cantidad): void {
        if ($cantidad > 0) {
            $this->items[] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }
    }

    public function getCliente(): Cliente {
        return $this->cliente;
    }

    public function getMetodoPago(): string {
        return $this->metodoPago;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getItems(): array {
        return $this->items;
    }

    // Calcula el subtotal acumulado de los productos sin incluir el IGV
    public function calcularSubtotal(): float {
        $subtotal = 0.0;
        foreach ($this->items as $item) {
            $subtotal += $item['producto']->getPrecio() * $item['cantidad'];
        }
        return $subtotal;
    }

    // Calcula el acumulado total de IGV de los productos que apliquen
    public function calcularTotalIgv(): float {
        $totalIgv = 0.0;
        foreach ($this->items as $item) {
            $producto = $item['producto'];
            $montoItem = $producto->getPrecio() * $item['cantidad'];
            $totalIgv += $montoItem * $producto->getTasaIgv();
        }
        return $totalIgv;
    }

    // Suma del Subtotal + el IGV acumulado (Importe Bruto)
    public function calcularSumaTotal(): float {
        return $this->calcularSubtotal() + $this->calcularTotalIgv();
    }

    // Determina el porcentaje de descuento por el monto de la compra (Escala de Negocio)
    public function getPorcentajeDescuentoMonto(): float {
        $sumaTotal = $this->calcularSumaTotal();
        
        if ($sumaTotal >= 100) {
            return 0.10; // 10%
        } elseif ($sumaTotal >= 30) {
            return 0.05; // 5%
        } else {
            return 0.00; // 0%
        }
    }

    // Devuelve el monto en soles restado por la escala de la compra
    public function getMontoDescuentoMonto(): float {
        return $this->calcularSumaTotal() * $this->getPorcentajeDescuentoMonto();
    }

    // Devuelve el monto en soles restado por el beneficio de tipo de cliente
    public function getMontoDescuentoCliente(): float {
        return $this->calcularSumaTotal() * $this->cliente->getPorcentajeDescuento();
    }

    // Calcula el Total Neto Final aplicando ambos descuentos concurrentes
    public function calcularTotalAPagar(): float {
        $sumaTotal = $this->calcularSumaTotal();
        $descuentoMonto = $this->getMontoDescuentoMonto();
        $descuentoCliente = $this->getMontoDescuentoCliente();
        
        return $sumaTotal - $descuentoMonto - $descuentoCliente;
    }

    // Devuelve el string del mensaje de pago correspondiente
    public function getMensajePago(): string {
        switch ($this->metodoPago) {
            case 'yape':
                return "Pago procesado via YAPE de forma inmediata.";
            case 'plin':
                return "Pago procesado via PLIN de forma inmediata.";
            case 'tarjeta':
                return "Pago con Tarjeta de Credito/Debito aceptado.";
            case 'efectivo':
            default:
                return "Pago en efectivo recibido en caja.";
        }
    }
}