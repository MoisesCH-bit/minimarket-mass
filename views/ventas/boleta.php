<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">
    <div style="max-width:520px;background:#fff;border-radius:12px;
                box-shadow:0 2px 8px rgba(0,0,0,.08);padding:32px;">

      <!-- Encabezado -->
      <div style="text-align:center;margin-bottom:24px;">
        <h2 style="color:#0066B3;margin:0;">🏪 MINIMARKET MASS</h2>
        <p style="margin:4px 0;color:#64748b;font-size:13px;">Boleta de Venta</p>
        <p style="font-weight:700;font-size:15px;"><?= htmlspecialchars($venta['numero_comprobante']) ?></p>
        <p style="color:#64748b;font-size:12px;"><?= $venta['fecha_venta'] ?></p>
      </div>

      <div style="border-top:2px dashed #e2e8f0;margin-bottom:16px;"></div>

      <!-- Cliente y cajero -->
      <p style="font-size:13px;margin:4px 0;">
        <strong>Cliente:</strong>
        <?= htmlspecialchars($venta['nombres'] . ' ' . $venta['apellidos']) ?>
        (DNI: <?= htmlspecialchars($venta['dni']) ?>)
      </p>
      <p style="font-size:13px;margin:4px 0;">
        <strong>Cajero:</strong>
        <?= htmlspecialchars($venta['cajero_nombres'] . ' ' . $venta['cajero_apellidos']) ?>
      </p>
      <p style="font-size:13px;margin:4px 0;">
        <strong>Pago:</strong> <?= ucfirst($venta['metodo_pago']) ?>
      </p>

      <div style="border-top:2px dashed #e2e8f0;margin:16px 0;"></div>

      <!-- Items -->
      <table style="width:100%;font-size:13px;">
        <thead>
          <tr style="color:#64748b;">
            <th style="text-align:left;padding:4px 0;">Producto</th>
            <th style="text-align:center;">Cant.</th>
            <th style="text-align:right;">Precio</th>
            <th style="text-align:right;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($venta['items'] as $item): ?>
          <tr>
            <td style="padding:4px 0;"><?= htmlspecialchars($item['nombre']) ?></td>
            <td style="text-align:center;"><?= $item['cantidad'] ?></td>
            <td style="text-align:right;">S/ <?= number_format($item['precio_unitario'], 2) ?></td>
            <td style="text-align:right;">S/ <?= number_format($item['subtotal'], 2) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="border-top:2px dashed #e2e8f0;margin:16px 0;"></div>

      <!-- Totales -->
      <div style="text-align:right;font-size:14px;">
        <p style="margin:4px 0;">Subtotal: <strong>S/ <?= number_format($venta['subtotal'], 2) ?></strong></p>
        <p style="margin:4px 0;">IGV (18%): <strong>S/ <?= number_format($venta['igv'], 2) ?></strong></p>
        <p style="margin:8px 0;font-size:18px;color:#0066B3;">
          TOTAL: <strong>S/ <?= number_format($venta['total'], 2) ?></strong>
        </p>
      </div>

      <div style="border-top:2px dashed #e2e8f0;margin:16px 0;"></div>

      <p style="text-align:center;color:#64748b;font-size:12px;">
        ¡Gracias por su compra!
      </p>

      <!-- Botones -->
      <div style="display:flex;gap:10px;margin-top:20px;">
        <a href="index.php?accion=nueva-venta"
           style="background:#0066B3;color:#fff;text-decoration:none;font-weight:700;
                  font-size:13px;padding:8px 18px;border-radius:8px;display:inline-block;">
          + Nueva Venta
        </a>
        <a href="index.php?accion=catalogo"
           style="background:#64748b;color:#fff;text-decoration:none;font-weight:700;
                  font-size:13px;padding:8px 18px;border-radius:8px;display:inline-block;">
          Ir al Catálogo
        </a>
      </div>

    </div>
  </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>