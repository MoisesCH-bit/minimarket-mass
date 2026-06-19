<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">

    <h1>Clientes del Minimarket Mass</h1>
    <p style="margin-bottom:16px;">Total de clientes: <strong><?= count($clientes) ?></strong></p>

    <a href="index.php?accion=nuevo-cliente"
       style="display:inline-block;margin-bottom:16px;background:#0066B3;color:#fff;
              padding:8px 16px;border-radius:8px;text-decoration:none;font-weight:700;">
      + Nuevo cliente
    </a>

    <table>
      <thead>
        <tr>
          <th>DNI</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Teléfono</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $c): ?>
        <tr>
          <td><?= htmlspecialchars($c->getDni()) ?></td>
          <td><?= htmlspecialchars($c->getNombres()) ?></td>
          <td><?= htmlspecialchars($c->getApellidos()) ?></td>
          <td><?= htmlspecialchars($c->getTelefono()) ?></td>
          <td><?= htmlspecialchars($c->getEmail()) ?></td>
          <td><?= htmlspecialchars($c->getTipoCliente()) ?></td>
          <td>
            <button onclick="abrirEditar(
                                '<?= htmlspecialchars($c->getDni(), ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($c->getNombres(), ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($c->getApellidos(), ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($c->getTelefono(), ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($c->getEmail(), ENT_QUOTES) ?>'
                             )"
                    style="background:#10b981;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;">
                Editar
            </button>
            <button onclick="abrirModal('<?= urlencode($c->getDni()) ?>','<?= htmlspecialchars($c->getNombres(), ENT_QUOTES) ?>')"
                    style="background:#ef4444;color:#fff;font-weight:700;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;margin-left:6px;">
                Eliminar
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if ($totalPaginas > 1): ?>
<div class="paginacion">
    <?php if ($paginaActual > 1): ?>
        <a href="index.php?accion=clientes&pagina=<?= $paginaActual - 1 ?>" class="pag-btn">← Anterior</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="index.php?accion=clientes&pagina=<?= $i ?>"
           class="pag-btn <?= $i === $paginaActual ? 'pag-activo' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
    <?php if ($paginaActual < $totalPaginas): ?>
        <a href="index.php?accion=clientes&pagina=<?= $paginaActual + 1 ?>" class="pag-btn">Siguiente →</a>
    <?php endif; ?>
</div>
<?php endif; ?>

  </main>
</div>

<!-- DRAWER: Editar cliente -->
<div id="drawer-overlay" onclick="cerrarDrawer()"></div>
<div id="drawer-nuevo">
  <button class="btn-cerrar-drawer" onclick="cerrarDrawer()">✕</button>
  <h2>Editar cliente</h2>

  <form method="POST" action="index.php?accion=actualizar-cliente">

    <label>DNI</label>
    <input type="text" id="d-dni-visible" readonly
           style="background:#f0f2f5; cursor:not-allowed;">
    <input type="hidden" name="dni" id="d-dni">

    <label>Nombres</label>
    <input type="text" name="nombres" id="d-nombres" required>

    <label>Apellidos</label>
    <input type="text" name="apellidos" id="d-apellidos" required>

    <label>Teléfono</label>
    <input type="text" name="telefono" id="d-telefono">

    <label>Email</label>
    <input type="email" name="email" id="d-email">

    <button type="submit" class="btn-guardar">Guardar cambios</button>
  </form>
</div>

<!-- MODAL: Confirmar eliminar -->
<div id="modal-eliminar">
  <div class="modal-card">
    <div class="icono">⚠️</div>
    <h2>¿Desactivar cliente?</h2>
    <p id="modal-texto"></p>
    <p class="nota">No se borrará, solo dejará de aparecer en la lista.</p>
    <div class="modal-btns">
      <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
      <a id="modal-confirmar" href="#" class="btn-confirmar">Sí, desactivar</a>
    </div>
  </div>
</div>

<script>
function abrirEditar(dni, nombres, apellidos, telefono, email) {
    document.getElementById('d-dni-visible').value = dni;
    document.getElementById('d-dni').value         = dni;
    document.getElementById('d-nombres').value     = nombres;
    document.getElementById('d-apellidos').value   = apellidos;
    document.getElementById('d-telefono').value    = telefono;
    document.getElementById('d-email').value       = email;

    document.getElementById('drawer-nuevo').classList.add('activo');
    document.getElementById('drawer-overlay').classList.add('activo');
    document.body.style.overflow = 'hidden';
}
function cerrarDrawer() {
    document.getElementById('drawer-nuevo').classList.remove('activo');
    document.getElementById('drawer-overlay').classList.remove('activo');
    document.body.style.overflow = '';
}
function abrirModal(dni, nombres) {
    document.getElementById('modal-texto').textContent = 'Vas a desactivar: ' + nombres;
    document.getElementById('modal-confirmar').href = 'index.php?accion=eliminar-cliente&dni=' + dni;
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
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>