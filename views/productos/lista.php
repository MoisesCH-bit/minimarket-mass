<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">

    <h1>Catálogo del Minimarket Mass</h1>
    <div style="margin: 16px 0;">
    <input type="text" id="buscador" placeholder="Buscar por nombre o código de barras..."
           style="width:100%; max-width:420px; padding:10px 14px; border:1px solid #d7dde6; border-radius:8px; font-size:14px;">
</div>
<p style="margin-bottom:16px;">Total de productos: <strong><?= $total ?></strong></p>

<div id="tabla-contenedor" class="catalogo-wrapper">
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
          <button onclick="abrirEditar(
                              '<?= htmlspecialchars($p->getCodigo(), ENT_QUOTES) ?>',
                              '<?= htmlspecialchars($p->getNombre(), ENT_QUOTES) ?>',
                              '<?= $p->getPrecio() ?>',
                              '<?= $p->getStock() ?>'
                           )"
                  style="background:#10b981;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;">
              Editar
          </button>
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
      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <a href="index.php?accion=catalogo&pagina=<?= $i ?>"
             class="pag-btn <?= $i === $paginaActual ? 'pag-activo' : '' ?>">
              <?= $i ?>
          </a>
      <?php endfor; ?>
  </div>
  <?php endif; ?>
  </main>
</div>

<!-- DRAWER: Editar producto -->
<div id="drawer-overlay" onclick="cerrarDrawer()"></div>
<div id="drawer-nuevo">
  <button class="btn-cerrar-drawer" onclick="cerrarDrawer()">✕</button>
  <h2>Editar producto</h2>

  <form method="POST" action="index.php?accion=actualizar-producto">

    <label>Código de barras</label>
    <input type="text" id="d-codigo-visible" readonly
           style="background:#f0f2f5; cursor:not-allowed;">
    <input type="hidden" name="codigo" id="d-codigo">

    <label>Nombre</label>
    <input type="text" name="nombre" id="d-nombre" required>

    <label>Precio (S/)</label>
    <input type="number" name="precio" id="d-precio" step="0.01" min="0" required>

    <label>Stock</label>
    <input type="number" name="stock" id="d-stock" min="0" required>

    <button type="submit" class="btn-guardar">Guardar cambios</button>
  </form>
</div>

<!-- MODAL: Confirmar eliminar -->
<div id="modal-eliminar">
  <div class="modal-card">
    <div class="icono">⚠️</div>
    <h2>¿Desactivar producto?</h2>
    <p id="modal-texto"></p>
    <p class="nota">No se borrará, solo dejará de aparecer en el catálogo.</p>
    <div class="modal-btns">
      <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
      <a id="modal-confirmar" href="#" class="btn-confirmar">Sí, desactivar</a>
    </div>
  </div>
</div>

<!-- JS: siempre al final -->
<script>
function abrirEditar(codigo, nombre, precio, stock) {
    document.getElementById('d-codigo-visible').value = codigo;
    document.getElementById('d-codigo').value          = codigo;
    document.getElementById('d-nombre').value          = nombre;
    document.getElementById('d-precio').value          = precio;
    document.getElementById('d-stock').value           = stock;

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
let timeoutBusqueda;
document.getElementById('buscador').addEventListener('input', function() {
    clearTimeout(timeoutBusqueda);
    const termino = this.value;

    timeoutBusqueda = setTimeout(() => {
        fetch('index.php?accion=buscar-producto-ajax&q=' + encodeURIComponent(termino))
            .then(res => res.json())
            .then(productos => renderizarTabla(productos, termino));
    }, 300); // espera 300ms después de dejar de escribir
});

function renderizarTabla(productos, termino) {
    const contenedor = document.getElementById('tabla-contenedor');

    if (termino.trim() === '') {
        location.reload(); // si borra todo, vuelve al catálogo paginado normal
        return;
    }

    if (productos.length === 0) {
        contenedor.innerHTML = '<p style="padding:20px; color:#64748b;">No se encontraron productos.</p>';
        return;
    }

    let html = '<table><thead><tr><th>Código</th><th>Nombre</th><th>Precio</th><th>Precio con IGV</th><th>Stock</th><th>Acciones</th></tr></thead><tbody>';

    productos.forEach(p => {
        const sinStock = p.stock === 0 ? ' class="sin-stock"' : '';
        html += `<tr>
            <td>${p.codigo}</td>
            <td>${p.nombre}</td>
            <td class="precio">S/ ${p.precio.toFixed(2)}</td>
            <td class="precio">S/ ${p.precioConIgv.toFixed(2)}</td>
            <td${sinStock}>${p.stock} unidades</td>
            <td>
                <button onclick="abrirEditar('${p.codigo}','${p.nombre.replace(/'/g, "\\'")}','${p.precio}','${p.stock}')"
                        style="background:#10b981;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;">
                    Editar
                </button>
                <button onclick="abrirModal('${encodeURIComponent(p.codigo)}','${p.nombre.replace(/'/g, "\\'")}')"
                        style="background:#ef4444;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;margin-left:6px;">
                    Eliminar
                </button>
            </td>
        </tr>`;
    });

    html += '</tbody></table>';
    contenedor.innerHTML = html;
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>