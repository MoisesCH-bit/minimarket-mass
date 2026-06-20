<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Minimarket Mass</title>
  <style>
    /* ===== RESET BASE ===== */
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; }
    html, body { height: 100%; overflow: hidden; }
    body { background: #f0f2f5; display: flex; flex-direction: column; min-height: 100vh; }

    /* ===== NAVBAR ===== */
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
    .navbar a.salir:hover { background: #e8f0f9; }

    /* ===== LAYOUT (fusionado: contenedor + sidebar fijo + main con scroll propio) ===== */
    .contenedor {
      display: flex;
      flex: 1;
      height: calc(100vh - 56px);
      overflow: hidden;
    }

    .sidebar {
      width: 200px; background: #004F8C; padding: 20px 0;
      display: flex; flex-direction: column;
      position: fixed;
      top: 56px;
      left: 0;
      height: calc(100vh - 56px);
      overflow-y: auto;
      z-index: 100;
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

    .contenido {
      margin-left: 200px;
    }

    main {
      flex: 1;
      padding: 28px 32px;
      overflow-y: auto;
      height: calc(100vh - 56px);
    }
    main h1 { color: #0066B3; border-bottom: 3px solid #FFB81C; padding-bottom: 3px; margin-bottom: 15px; }

    /* ===== TABLA ===== */
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 6px rgba(0,0,0,.08); border-radius: 8px; overflow: hidden; }
    th { background: #0066B3; color: white; padding: 12px 14px; text-align: left; font-size: 14px; }
    td { padding: 10px 14px; border-bottom: 1px solid #eee; font-size: 14px; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f4f8ff; }
    .precio    { font-weight: bold; color: #0066B3; }
    .sin-stock { color: #c33; font-weight: 600; }

/* ===== PAGINACIÓN ===== */
.catalogo-wrapper {
    display: flex;
    flex-direction: column;
    min-height: calc(100vh - 56px - 240px);
}
.catalogo-wrapper .paginacion {
    margin-top: auto;
}
.paginacion {
    display: flex; gap: 8px; justify-content: center;
    align-items: center; margin-top: 28px; margin-bottom: 8px; flex-wrap: wrap;
}
.pag-btn {
    padding: 8px 16px; border-radius: 8px; border: 1px solid #d7dde6;
    background: #fff; color: #0066B3; font-size: 13px; font-weight: 600;
    text-decoration: none; display: inline-block; transition: all .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.pag-btn:hover { background: #0066B3; color: #fff; border-color: #0066B3; }
.pag-activo { background: #0066B3; color: #fff; border-color: #0066B3; box-shadow: 0 2px 8px rgba(0,102,179,0.3); }
.pag-activo:hover { background: #004f8c; }

    /* ===== BOTONES GENERALES ===== */
    .btn-primario {
      background: #0066B3; color: #fff; border: none;
      border-radius: 8px; padding: 9px 18px; font-weight: 700; font-size: 14px; cursor: pointer;
    }
    .btn-primario:hover { background: #004f8c; }
    .btn-guardar {
      width: 100%; margin-top: 20px; padding: 11px; border: none;
      border-radius: 8px; background: #0066B3; color: #fff; font-weight: 700; font-size: 15px; cursor: pointer;
    }
    .btn-guardar:hover { background: #004f8c; }

    /* ===== DRAWER ===== */
    #drawer-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.45); z-index: 100;
    }
    #drawer-overlay.activo { display: block; }
    #drawer-nuevo {
      position: fixed; top: 0; right: 0; width: 380px; height: 100%;
      background: #fff; z-index: 101; box-shadow: -6px 0 30px rgba(0,0,0,0.15);
      transform: translateX(100%); transition: transform .3s ease;
      overflow-y: auto; padding: 32px 28px;
    }
    #drawer-nuevo.activo { transform: translateX(0); }
    #drawer-nuevo h2 {
      color: #0066B3; font-size: 20px; margin: 0 0 20px;
      border-bottom: 3px solid #FFB81C; padding-bottom: 10px;
    }
    #drawer-nuevo label {
      display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1e293b;
    }
    #drawer-nuevo input,
    #drawer-nuevo select {
      width: 100%; padding: 9px 12px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;
    }
    #drawer-nuevo input:focus,
    #drawer-nuevo select:focus { outline: none; border-color: #0066B3; box-shadow: 0 0 0 3px rgba(0,102,179,0.1); }
    .btn-cerrar-drawer {
      position: absolute; top: 16px; right: 20px;
      background: none; border: none; font-size: 22px; cursor: pointer; color: #64748b;
    }
    .error-drawer {
      background: #fef2f2; border: 1px solid #f3c2c2; color: #b91c1c;
      padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 10px;
    }

    /* ===== MODAL ===== */
    #modal-eliminar {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.5); z-index: 200;
      justify-content: center; align-items: center;
    }
    #modal-eliminar.activo { display: flex; }
    .modal-card {
      background: #fff; border-radius: 14px; padding: 36px 32px;
      max-width: 400px; width: 90%; text-align: center;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    .modal-card .icono { font-size: 48px; margin-bottom: 12px; }
    .modal-card h2    { margin: 0 0 8px; color: #1e293b; font-size: 18px; border: none; }
    .modal-card p     { color: #64748b; margin-bottom: 6px; font-size: 14px; }
    .modal-card .nota { font-size: 12px; color: #94a3b8; margin-bottom: 24px; }
    .modal-btns { display: flex; gap: 12px; justify-content: center; }
    .btn-cancelar {
      padding: 10px 24px; border-radius: 8px; border: 1px solid #cbd5e1;
      background: #fff; color: #475569; font-weight: 600; cursor: pointer;
    }
    .btn-cancelar:hover { background: #f8fafc; }
    .btn-confirmar {
      padding: 10px 24px; border-radius: 8px; background: #ef4444;
      color: #fff; font-weight: 600; text-decoration: none; display: inline-block;
    }
    .btn-confirmar:hover { background: #dc2626; }

    /* ===== FOOTER ===== */
    .footer {
      background: #003d70; color: #a0bcd4;
      text-align: center; padding: 12px; font-size: 12px;
    }
    .footer strong { color: #FFB81C; }

    /* ===== BUSCADOR ===== */
    #buscador:focus {
      outline: none;
      border-color: #0066B3;
      box-shadow: 0 0 0 3px rgba(0,102,179,0.1);
    }
  </style>
</head>
<body>