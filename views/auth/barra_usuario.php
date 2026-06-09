<?php
declare(strict_types=1);
$u = usuarioActual();
?>
<div style="background:#0066B3;color:#fff;padding:10px 20px;display:flex;align-items:center;justify-content:space-between;font-family:'Segoe UI',Arial,sans-serif;">
  <div>
    <strong><?= htmlspecialchars($u['nombre']) ?></strong>
    &nbsp;·&nbsp;
    <?php if ($u['rol'] === 'admin'): ?>
      <span style="background:#f59e0b;color:#000;padding:2px 10px;border-radius:20px;font-size:13px;font-weight:700;">Modo administrador</span>
    <?php else: ?>
      <span style="background:#10b981;color:#fff;padding:2px 10px;border-radius:20px;font-size:13px;font-weight:700;">Caja</span>
    <?php endif; ?>
    &nbsp;·&nbsp; Tienda: <em><?= htmlspecialchars($u['tienda']) ?></em>
    &nbsp;·&nbsp; Último acceso:
    <em><?= htmlspecialchars($u['ultimo_acceso']
        ? date('d/m/Y H:i', strtotime($u['ultimo_acceso']))
        : 'Primera sesión') ?>
    </em>
  </div>
  <a href="index.php?accion=logout" style="background:#fff;color:#0066B3;padding:6px 16px;border-radius:8px;text-decoration:none;font-weight:700;font-size:13px;">Salir</a>
</div>