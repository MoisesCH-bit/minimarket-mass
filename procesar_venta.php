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
// --- 3. REGLAS 2 Y 3: PROCESAMIENTO DE PRODUCTOS (IGV Y SUBTOTALES) ---
$productos_procesados = [];

foreach ($productos as $prod) {
    // Regla 2: Asignación de IGV por categoría
    switch ($prod['categoria']) {
        case 'abarrotes':
        case 'bebidas':
        case 'lácteos':
        case 'limpieza':
        case 'aseo personal':
            $tasa_igv = 0.18;
            break;
        case 'panadería':
        case 'frutas y verduras':
            $tasa_igv = 0.00; // Inafecto
            break;
        default:
            $tasa_igv = 0.18;
            break;
    }

    // Regla 3: Cálculos individuales
    $subtotal_p   = $prod['precio'] * $prod['cantidad'];
    $igv_p        = $subtotal_p * $tasa_igv;
    $total_p      = $subtotal_p + $igv_p;

    // Acumular en las variables globales de la tienda
    $subtotal_tienda  += $subtotal_p;
    $total_igv_tienda += $igv_p;
    $total_bruto      += $total_p;

    // Guardar para el diseño de la boleta posterior
    $productos_procesados[] = [
        "nombre"   => $prod['nombre'],
        "precio"   => $prod['precio'],
        "cantidad" => $prod['cantidad'],
        "subtotal" => $subtotal_p,
        "igv"      => $igv_p,
        "total"    => $total_p
    ];
}