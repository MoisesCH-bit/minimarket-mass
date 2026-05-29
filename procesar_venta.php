<?php
// ============================================================================
// SISTEMA MASS - MÓDULO: procesar_venta.php
// ============================================================================

// --- 1. ENTRADA DE DATOS (Variables iniciales) ---
$cliente_nombre = "Moises Colca";
$cliente_dni    = "72145678"; // Prueben poner letras o menos números para testear
$cliente_tipo   = "vip";       // opciones: regular / frecuente / vip
$metodo_pago    = "tarjeta";   // opciones: efectivo / yape / plin / tarjeta

// Lista de productos del minimarket (Array)
$productos = [
    ["nombre" => "Inca Kola 3L", "categoria" => "bebidas", "precio" => 11.50, "cantidad" => 3],
    ["nombre" => "Arroz Costeño 5kg", "categoria" => "abarrotes", "precio" => 24.50, "cantidad" => 2],
    ["nombre" => "Leche Gloria Six Pack", "categoria" => "lácteos", "precio" => 26.00, "cantidad" => 1]
];

// Acumuladores generales
$subtotal_tienda  = 0;
$total_igv_tienda = 0;
$total_bruto      = 0;

// --- 2. REGLA 1: VALIDACIÓN DE DNI ---
if (strlen($cliente_dni) !== 8 || !ctype_digit($cliente_dni)) {
    echo "<div style='color:red; font-weight:bold; padding:20px; border:1px solid red;'>";
    echo "ERROR: El DNI debe tener exactamente 8 caracteres numéricos.";
    echo "</div>";
    exit; // Detiene el sistema de inmediato si falla
}