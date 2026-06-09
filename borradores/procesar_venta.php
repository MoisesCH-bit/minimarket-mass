<?php
// ============================================================
// MODULO: procesar_venta.php
// Sistema de Inventario Minimarket Mass
// ============================================================

// Configuracion de zona horaria
date_default_timezone_set('America/Lima');

// ============================================================
// DATOS DE ENTRADA (Simulacion de variables)
// ============================================================
$cliente_nombre = "Maria Elena Garcia";
$cliente_dni = "45678912";
$cliente_tipo = "vip"; // opciones: regular, frecuente, vip
$metodo_pago = "efectivo"; // opciones: efectivo, yape, plin, tarjeta

// Productos comprados
$productos = [
    [
        "nombre" => "Inca Kola 1.5L",
        "categoria" => "bebidas",
        "precio" => 6.50,
        "cantidad" => 2
    ],
    [
        "nombre" => "Arroz Costeño 750g",
        "categoria" => "abarrotes",
        "precio" => 4.20,
        "cantidad" => 5
    ],
    [
        "nombre" => "Pan Frances",
        "categoria" => "panaderia",
        "precio" => 0.30,
        "cantidad" => 15
    ]
];

// ============================================================
// VALIDACION DE DNI
// ============================================================
if (strlen($cliente_dni) !== 8 || !is_numeric($cliente_dni)) {
    echo "<h3>Error en la operacion</h3>";
    echo "<p>El DNI ingresado no es valido. Debe contener exactamente 8 digitos numericos.</p>";
    exit;
}

// ============================================================
// PROCESAMIENTO DE PRODUCTOS 
// ============================================================
$total_subtotal = 0;
$total_igv = 0;
$filas_detalle = "";

foreach ($productos as $item) {
    $nombre_prod = $item["nombre"];
    $cat_prod = $item["categoria"];
    $precio_unitario = $item["precio"];
    $cantidad_comprada = $item["cantidad"];

    // IGV segun categoria
    $tasa_igv = 0;
    switch ($cat_prod) {
        case 'abarrotes':
        case 'bebidas':
        case 'lacteos':
        case 'limpieza':
        case 'aseo personal':
            $tasa_igv = 0.18;
            break;
        case 'panaderia':
        case 'frutas y verduras':
            $tasa_igv = 0.00;
            break;
    }

    // Subtotal por producto
    $subtotal_item = $precio_unitario * $cantidad_comprada;
    $igv_item = $subtotal_item * $tasa_igv;
    $total_item = $subtotal_item + $igv_item;

    $total_subtotal = $total_subtotal + $subtotal_item;
    $total_igv = $total_igv + $igv_item;

    // Construyendo filas del HTML 
    $filas_detalle = $filas_detalle . "<tr>" .
        "<td style='border: 1px solid #ccc; padding: 8px;'>" . $nombre_prod . "</td>" .
        "<td style='border: 1px solid #ccc; padding: 8px; text-align: center;'>" . $cantidad_comprada . "</td>" .
        "<td style='border: 1px solid #ccc; padding: 8px; text-align: right;'>S/ " . number_format($precio_unitario, 2) . "</td>" .
        "<td style='border: 1px solid #ccc; padding: 8px; text-align: right;'>S/ " . number_format($igv_item, 2) . "</td>" .
        "<td style='border: 1px solid #ccc; padding: 8px; text-align: right;'>S/ " . number_format($total_item, 2) . "</td>" .
        "</tr>";
}

$suma_total = $total_subtotal + $total_igv;

// ============================================================
// DESCUENTO POR MONTO TOTAL
// ============================================================
$descuento_monto_pct = 0;
if ($suma_total < 30) {
    $descuento_monto_pct = 0;
} elseif ($suma_total >= 30 && $suma_total <= 99.99) {
    $descuento_monto_pct = 0.05;
} elseif ($suma_total >= 100 && $suma_total <= 199.99) {
    $descuento_monto_pct = 0.10;
} elseif ($suma_total >= 200) {
    $descuento_monto_pct = 0.15;
}

// ============================================================
// DESCUENTO ADICIONAL POR TIPO CLIENTE
// ============================================================
$descuento_tipo_pct = 0;
if ($cliente_tipo == 'frecuente') {
    $descuento_tipo_pct = 0.02;
} elseif ($cliente_tipo == 'vip') {
    $descuento_tipo_pct = 0.05;
}

// Calculo de descuentos finales
$porcentaje_total = $descuento_monto_pct + $descuento_tipo_pct;
$monto_descuento = $suma_total * $porcentaje_total;
$total_final = $suma_total - $monto_descuento;

// ============================================================
// VALIDACION DE METODO DE PAGO
// ============================================================
$mensaje_pago = "";
switch ($metodo_pago) {
    case 'efectivo':
        $mensaje_pago = "Pago en efectivo - exacto preferido.";
        if ($total_final > 500) {
            $mensaje_pago = $mensaje_pago . " (Advertencia: Se sugiere otro metodo para montos altos).";
        }
        break;
    case 'yape':
    case 'plin':
        $mensaje_pago = "Mostrar QR del comercio.";
        break;
    case 'tarjeta':
        $mensaje_pago = "Insertar tarjeta en POS.";
        break;
}

// ============================================================
// SALUDO SEGUN HORA ACTUAL
// ============================================================
$hora_actual = (int)date('H');
$saludo = "";

if ($hora_actual >= 5 && $hora_actual <= 11) {
    $saludo = "Buenos dias";
} elseif ($hora_actual >= 12 && $hora_actual <= 18) {
    $saludo = "Buenas tardes";
} elseif ($hora_actual >= 19 && $hora_actual <= 23) {
    $saludo = "Buenas noches";
} else {
    $saludo = "Tienda cerrada";
}

$fecha_actual = date('Y-m-d H:i:s');

// ============================================================
// COMPROBANTE DE VENTA
// ============================================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Venta - Minimarket Mass</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .ticket { background: #fff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #d32f2f; text-align: center; margin-bottom: 5px; }
        h3 { text-align: center; margin-top: 0; color: #555; }
        .datos-cabecera { margin-bottom: 20px; border-bottom: 2px dashed #ccc; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f8f8f8; border: 1px solid #ccc; padding: 8px; text-align: center; }
        .totales { width: 50%; float: right; border-collapse: collapse; }
        .totales td { padding: 5px; text-align: right; }
        .instrucciones { clear: both; margin-top: 40px; padding: 15px; background-color: #e9ecef; border-radius: 5px; text-align: center;}
        .bold { font-weight: bold; }
    </style>
</head>
<body>

<div class="ticket">
    <h1>MINIMARKET MASS</h1>
    <h3>Tu tienda de confianza</h3>

    <div class="datos-cabecera">
        <p><strong>Fecha y Hora:</strong> <?php echo $fecha_actual; ?></p>
        <p><strong><?php echo $saludo; ?>,</strong> <?php echo $cliente_nombre; ?></p>
        <p><strong>DNI:</strong> <?php echo $cliente_dni; ?> | <strong>Tipo de Cliente:</strong> <?php echo strtoupper($cliente_tipo); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio Unit.</th>
                <th>IGV</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $filas_detalle; ?>
        </tbody>
    </table>

    <table class="totales">
        <tr>
            <td>Subtotal sin IGV:</td>
            <td>S/ <?php echo number_format($total_subtotal, 2); ?></td>
        </tr>
        <tr>
            <td>Total IGV (18% / 0%):</td>
            <td>S/ <?php echo number_format($total_igv, 2); ?></td>
        </tr>
        <tr>
            <td class="bold">Importe Bruto:</td>
            <td class="bold">S/ <?php echo number_format($suma_total, 2); ?></td>
        </tr>
        <tr>
            <td style="color: red;">Descuento por Monto (<?php echo $descuento_monto_pct * 100; ?>%):</td>
            <td style="color: red;">- S/ <?php echo number_format($suma_total * $descuento_monto_pct, 2); ?></td>
        </tr>
        <tr>
            <td style="color: red;">Dscto. Cliente <?php echo ucfirst($cliente_tipo); ?> (<?php echo $descuento_tipo_pct * 100; ?>%):</td>
            <td style="color: red;">- S/ <?php echo number_format($suma_total * $descuento_tipo_pct, 2); ?></td>
        </tr>
        <tr>
            <td class="bold" style="font-size: 1.2em;">TOTAL A PAGAR:</td>
            <td class="bold" style="font-size: 1.2em;">S/ <?php echo number_format($total_final, 2); ?></td>
        </tr>
    </table>

    <div class="instrucciones">
        <p><strong>Método de Pago:</strong> <?php echo strtoupper($metodo_pago); ?></p>
        <p><?php echo $mensaje_pago; ?></p>
    </div>
</div>

</body>
</html>