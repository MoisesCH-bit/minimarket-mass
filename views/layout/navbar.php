<?php $u = usuarioActual(); ?>

<nav class="navbar">
  <div class="logo">🛒 <span>MASS</span> · Sistema de Caja</div>
  <div class="usuario">
    👤 <strong><?= htmlspecialchars($u['nombre']) ?></strong>
    <span class="rol-badge"><?= htmlspecialchars(ucfirst($u['rol'])) ?></span>
    <?php if (!empty($u['ultimo_acceso'])): ?>
      <em style="font-size:13px; color:#fff;">
        Último acceso: <?= htmlspecialchars(date('d/m/Y H:i', strtotime($u['ultimo_acceso']))) ?>
      </em>
    <?php endif; ?>
    <a href="index.php?accion=logout" class="salir">Salir</a>
  </div>
</nav>

<div class="contenedor">