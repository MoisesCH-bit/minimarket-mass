<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">
    <h1>Nuevo Cliente</h1>

    <?php if (!empty($error)): ?>
      <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <div style="background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08);
                padding: 32px; max-width: 500px;">

      <form method="POST" action="index.php?accion=guardar-cliente">

        <div style="margin-bottom:18px;">
          <label style="font-weight:600; display:block; margin-bottom:6px;">DNI (8 dígitos)</label>
          <input type="text" name="dni" maxlength="8" required
                 style="width:100%; padding:10px 12px; border:1px solid #ccc;
                        border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:18px;">
          <label style="font-weight:600; display:block; margin-bottom:6px;">Nombres</label>
          <input type="text" name="nombres" required
                 style="width:100%; padding:10px 12px; border:1px solid #ccc;
                        border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:18px;">
          <label style="font-weight:600; display:block; margin-bottom:6px;">Apellidos</label>
          <input type="text" name="apellidos" required
                 style="width:100%; padding:10px 12px; border:1px solid #ccc;
                        border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:18px;">
          <label style="font-weight:600; display:block; margin-bottom:6px;">Teléfono</label>
          <input type="text" name="telefono"
                 style="width:100%; padding:10px 12px; border:1px solid #ccc;
                        border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="margin-bottom:24px;">
          <label style="font-weight:600; display:block; margin-bottom:6px;">Email</label>
          <input type="email" name="email"
                 style="width:100%; padding:10px 12px; border:1px solid #ccc;
                        border-radius:6px; font-size:14px; box-sizing:border-box;">
        </div>

        <div style="display:flex; gap:12px;">
          <button type="submit"
                  style="background:#0066B3; color:#fff; padding:10px 22px;
                         border:none; border-radius:8px; font-weight:700;
                         font-size:14px; cursor:pointer;">
            Guardar cliente
          </button>
          <a href="index.php?accion=clientes"
             style="background:#6b7280; color:#fff; padding:10px 22px;
                    border-radius:8px; font-weight:700; font-size:14px;
                    text-decoration:none; display:inline-block;">
            Volver a Clientes
          </a>
        </div>

      </form>
    </div>
  </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>