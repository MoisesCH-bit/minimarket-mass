<?php $u = usuarioActual(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Minimarket Mass</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; }
    body { background: #f0f2f5; display: flex; flex-direction: column; min-height: 100vh; }

    /* NAVBAR */
    .navbar {
      background: #0066B3; color: #fff;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 24px; height: 56px; position: sticky; top: 0; z-index: 100;
    }
    .navbar .logo { font-size: 18px; font-weight: 800; letter-spacing: 1px; }
    .navbar .logo span { color: #FFB81C; }
    .navbar .usuario { display: flex; align-items: center; gap: 14px; font-size: 14px; }
    .navbar .rol-badge {
      background: #FFB81C; color: #000;
      padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700;
    }
    .navbar a.salir {
      background: #fff; color: #0066B3;
      padding: 6px 14px; border-radius: 8px;
      text-decoration: none; font-weight: 700; font-size: 13px;
    }

    /* LAYOUT */
    .contenedor { display: flex; flex: 1; }

    /* SIDEBAR */
    .sidebar {
      width: 200px; background: #004F8C; padding: 20px 0;
      display: flex; flex-direction: column; min-height: calc(100vh - 56px - 40px);
    }
    .sidebar a {
      color: #cce0f5; text-decoration: none;
      padding: 12px 20px; font-size: 14px; font-weight: 600;
      display: block; border-left: 3px solid transparent;
      transition: background .2s;
    }
    .sidebar a:hover { background: #003d70; color: #fff; }
    .sidebar a.activo { background: #003d70; color: #FFB81C; border-left: 3px solid #FFB81C; }
    .sidebar .separador { height: 1px; background: #003d70; margin: 8px 16px; }
    .sidebar a.disabled { color: #6a9bbf; cursor: not-allowed; pointer-events: none; }

    /* MAIN */
    main { flex: 1; padding: 28px 32px; }
    main h1 { color: #0066B3; border-bottom: 3px solid #FFB81C; padding-bottom: 10px; margin-bottom: 18px; }
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 6px rgba(0,0,0,.08); border-radius: 8px; overflow: hidden; }
    th { background: #0066B3; color: white; padding: 12px 14px; text-align: left; font-size: 14px; }
    td { padding: 10px 14px; border-bottom: 1px solid #eee; font-size: 14px; }
    tr:hover { background: #f4f8ff; }
    .precio { font-weight: bold; color: #0066B3; }
    .sin-stock { color: #c33; }

    /* FOOTER */
    .footer {
      background: #003d70; color: #a0bcd4;
      text-align: center; padding: 12px;
      font-size: 12px;
    }
    .footer strong { color: #FFB81C; }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="logo">🛒 <span>MASS</span> · Sistema de Caja</div>
  <div class="usuario">
    👤 <strong><?= htmlspecialchars($u['nombre']) ?></strong>
    <span class="rol-badge"><?= htmlspecialchars(ucfirst($u['rol'])) ?></span>
    <?php if (!empty($u['ultimo_acceso'])): ?>
<em style="font-size:13px;color:#fff;">
  Último acceso: <?= htmlspecialchars(date('d/m/Y H:i', strtotime($u['ultimo_acceso']))) ?>
</em>
    <?php endif; ?>
    <a href="index.php?accion=logout" class="salir">Salir</a>
  </div>
</nav>

<div class="contenedor">