<?php $u = usuarioActual(); ?>
<nav class="navbar">
    <div class="navbar-brand">
        🛒 MASS · Sistema de Caja
    </div>
    <div class="navbar-user">
        👤 <?= htmlspecialchars($u['nombre']) ?> · <?= htmlspecialchars(ucfirst($u['rol'])) ?>
        <a href="index.php?accion=logout" class="btn-salir">Salir</a>
    </div>
</nav>