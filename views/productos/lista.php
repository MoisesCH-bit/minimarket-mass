<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>        <!-- ← reemplaza barra_usuario.php -->

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>     <!-- ← nuevo -->

  <main class="contenido">
    <h1>Catálogo del Minimarket Mass</h1>
    <p>Total de productos: <strong><?= count($productos) ?></strong></p>

    <table>
      <thead>
        <tr>
          <th>Código</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Precio con IGV</th>
          <th>Stock</th>
           <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p->getCodigo()) ?></td>
          <td><?= htmlspecialchars($p->getNombre()) ?></td>
          <td class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
          <td class="precio">S/ <?= number_format($p->precioConIGV(), 2) ?></td>
          <td <?= $p->getStock() === 0 ? 'class="sin-stock"' : '' ?>>
            <?= $p->getStock() ?> unidades
          </td>
          <td>
        <a href="index.php?accion=editar-producto&codigo=<?= urlencode($p->getCodigo()) ?>" 
   style="background: #10b981; color: #fff; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 6px; text-decoration: none; display: inline-block;">
   Editar
</a>
          </td>
          <td>gi

    <!-- Botón Eliminar (Nuevo) -->
    <a href="index.php?accion=eliminar-producto&codigo=<?= urlencode($p->getCodigo()) ?>" 
       onclick="return confirmarEliminacion('<?= htmlspecialchars($p->getNombre()) ?>')"
       style="background: #ef4444; color: #fff; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 6px; text-decoration: none; display: inline-block;">
       Eliminar
    </a>
</td>

        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>

</div>
<script>
function confirmarEliminacion(nombre) {
    return confirm("¿Estás seguro de que deseas eliminar el producto: " + nombre + "?");
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>