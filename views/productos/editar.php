<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
    <?php require __DIR__ . '/../layout/sidebar.php'; ?>

    <main>
        <h1>Editar producto</h1>

        <?php if (!empty($error)): ?>
            <div style="background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;
                        padding:10px;border-radius:8px;margin-bottom:12px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=actualizar-producto" method="POST"
              style="max-width:460px;background:#fff;padding:24px;border-radius:12px;
                     box-shadow:0 2px 8px rgba(0,0,0,.08);">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">
                Código de barras
            </label>
            <input type="text" value="<?= htmlspecialchars($producto->getCodigo()) ?>"
                   readonly style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;background:#f0f2f5;margin-bottom:12px;">
            <input type="hidden" name="codigo" value="<?= htmlspecialchars($producto->getCodigo()) ?>">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Nombre</label>
            <input type="text" name="nombre"
                   value="<?= htmlspecialchars($producto->getNombre()) ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Precio (S/)</label>
            <input type="number" name="precio" step="0.01" min="0"
                   value="<?= htmlspecialchars($producto->getPrecio()) ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Stock</label>
            <input type="number" name="stock" min="0"
                   value="<?= htmlspecialchars($producto->getStock()) ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:16px;">

<div style="margin-top: 20px; display: flex; gap: 10px;">
    
    <button type="submit" 
            style="background: #0066B3; color: #fff; border: none; font-weight: 700; font-size: 13px; padding: 8px 18px; border-radius: 8px; cursor: pointer;">
        Guardar Cambios
    </button>
    
    <a href="index.php?accion=panel" 
       style="background: #64748b; color: #fff; text-decoration: none; font-weight: 700; font-size: 13px; padding: 8px 18px; border-radius: 8px; display: inline-block;">
        Volver al Catalogo
    </a>

</div>
        </form>
    </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>