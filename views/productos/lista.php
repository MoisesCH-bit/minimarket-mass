<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
      <h1 style="margin:0;">Catálogo del Minimarket Mass</h1>
      <button class="btn-primario" onclick="abrirDrawer()">+ Nuevo producto</button>
    </div>
    <p>Total de productos: <strong><?= $total ?></strong></p>

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
               style="background:#10b981;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;text-decoration:none;display:inline-block;">
                Editar
            </a>
            <button onclick="abrirModal('<?= urlencode($p->getCodigo()) ?>','<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>')"
                    style="background:#ef4444;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;margin-left:6px;">
                Eliminar
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- PAGINACIÓN -->
    <?php if ($totalPaginas > 1): ?>
    <div class="paginacion">
        <?php if ($paginaActual > 1): ?>
            <a href="index.php?accion=catalogo&pagina=<?= $paginaActual - 1 ?>" class="pag-btn">← Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="index.php?accion=catalogo&pagina=<?= $i ?>"
               class="pag-btn <?= $i === $paginaActual ? 'pag-activo' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($paginaActual < $totalPaginas): ?>
            <a href="index.php?accion=catalogo&pagina=<?= $paginaActual + 1 ?>" class="pag-btn">Siguiente →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

  </main>
</div>

<!-- DRAWER: Nuevo producto -->
<div id="drawer-overlay" onclick="cerrarDrawer()"></div>
<div id="drawer-nuevo">
  <button class="btn-cerrar-drawer" onclick="cerrarDrawer()">✕</button>
  <h2>Nuevo producto</h2>
  <?php if (!empty($error)): ?>
    <div class="error-drawer"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" action="index.php?accion=guardar-producto">
    <label>Código de barras</label>
    <input type="text" name="codigo">
    <label>Nombre</label>
    <input type="text" name="nombre">
    <label>Marca</label>
    <input type="text" name="marca">
    <label>Categoría</label>
    <select name="categoria">
      <option value="1">Abarrotes</option>
      <option value="2">Bebidas</option>
      <option value="3">Lácteos</option>
      <option value="4">Limpieza</option>
      <option value="5">Aseo Personal</option>
      <option value="6">Panadería</option>
      <option value="7">Frutas y Verduras</option>
    </select>
    <label>Precio (S/)</label>
    <input type="number" step="0.10" name="precio">
    <label>Stock</label>
    <input type="number" name="stock">
    <button type="submit" class="btn-guardar">Guardar producto</button>
  </form>
</div>

<!-- MODAL: Confirmar eliminar -->
<div id="modal-eliminar">
  <div class="modal-card">
    <div class="icono">⚠️</div>
    <h2>¿Eliminar producto?</h2>
    <p id="modal-texto"></p>
    <p class="nota">Dejará de aparecer en el catálogo.</p>
    <div class="modal-btns">
      <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
      <a id="modal-confirmar" href="#" class="btn-confirmar">Sí, eliminar</a>
    </div>
  </div>
</div>

<!-- JS: siempre al final, después de todos los elementos -->
<script>
function abrirDrawer() {
    document.getElementById('drawer-nuevo').classList.add('activo');
    document.getElementById('drawer-overlay').classList.add('activo');
    document.body.style.overflow = 'hidden';
}
function cerrarDrawer() {
    document.getElementById('drawer-nuevo').classList.remove('activo');
    document.getElementById('drawer-overlay').classList.remove('activo');
    document.body.style.overflow = '';
}
function abrirModal(codigo, nombre) {
    document.getElementById('modal-texto').textContent = 'Vas a desactivar: ' + nombre;
    document.getElementById('modal-confirmar').href = 'index.php?accion=eliminar-producto&codigo=' + codigo;
    document.getElementById('modal-eliminar').classList.add('activo');
    document.body.style.overflow = 'hidden';
}
function cerrarModal() {
    document.getElementById('modal-eliminar').classList.remove('activo');
    document.body.style.overflow = '';
}
document.getElementById('modal-eliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
<?php if (!empty($error)): ?>
window.addEventListener('DOMContentLoaded', () => abrirDrawer());
<?php endif; ?>
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>