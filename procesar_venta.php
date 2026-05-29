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
// --- 4. REGLA 4: DESCUENTO POR MONTO TOTAL ---
$porcentaje_desc_monto = 0;

if ($total_bruto < 30) {
    $porcentaje_desc_monto = 0.00;
} elseif ($total_bruto >= 30 && $total_bruto < 100) {
    $porcentaje_desc_monto = 0.05;
} elseif ($total_bruto >= 100 && $total_bruto < 200) {
    $porcentaje_desc_monto = 0.10;
} else {
    $porcentaje_desc_monto = 0.15;
}
$descuento_monto = $total_bruto * $porcentaje_desc_monto;


// --- 5. REGLA 5: DESCUENTO ADICIONAL POR TIPO DE CLIENTE ---
$porcentaje_desc_cliente = 0;

if ($cliente_tipo === 'frecuente') {
    $porcentaje_desc_cliente = 0.02;
} elseif ($cliente_tipo === 'vip') {
    $porcentaje_desc_cliente = 0.05;
} else {
    $porcentaje_desc_cliente = 0.00;
}
$descuento_cliente = $total_bruto * $porcentaje_desc_cliente;

// Totales definitivos
$total_descuentos = $descuento_monto + $descuento_cliente;
$total_a_pagar    = $total_bruto - $total_descuentos;
// --- 6. REGLA 6: VALIDACIÓN DE MÉTODO DE PAGO ---
$instruccion_pago = "";
$advertencia_pago = "";

switch ($metodo_pago) {
    case 'efectivo':
        $instruccion_pago = "Pago en efectivo - exacto preferido";
        break;
    case 'yape':
    case 'plin':
        $instruccion_pago = "Mostrar QR del comercio";
        break;
    case 'tarjeta':
        $instruccion_pago = "Insertar tarjeta en POS";
        break;
    default:
        $instruccion_pago = "Método de pago desconocido";
        break;
}

if ($total_a_pagar > 500 && $metodo_pago === 'efectivo') {
    $advertencia_pago = "Se sugiere otro método para montos altos";
}


// --- 7. REGLA 7: SALUDO SEGÚN HORA ACTUAL ---
date_default_timezone_set('America/Lima'); // Zona horaria de Perú
$hora_actual = (int)date('H');
$saludo = "";

if ($hora_actual >= 5 && $hora_actual <= 11) {
    $saludo = "Buenos días";
} elseif ($hora_actual >= 12 && $hora_actual <= 18) {
    $saludo = "Buenas tardes";
} elseif ($hora_actual >= 19 && $hora_actual <= 23) {
    $saludo = "Buenas noches";
} else {
    $saludo = "Tienda cerrada";
}
?>