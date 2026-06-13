<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="contenedor">
    <?php require __DIR__ . '/../layout/sidebar.php'; ?>

    <main class="contenido">
        <h1>Nuevo producto</h1>

        <?php if (!empty($error)): ?>
            <div style="background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;
                        padding:10px;border-radius:8px;margin-bottom:12px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=guardar-producto" method="POST"
              style="max-width:460px;background:#fff;padding:24px;border-radius:12px;
                     box-shadow:0 2px 8px rgba(0,0,0,.08);">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">
                Código de barras
            </label>
            <input type="text" name="codigo"
                   value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>"
                   style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Nombre</label>
            <input type="text" name="nombre"
                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Marca</label>
            <input type="text" name="marca"
                   value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>"
                   style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Categoría</label>
            <select name="categoria"
                    style="width:100%;padding:9px;border:1px solid #d7dde6;
                    border-radius:8px;margin-bottom:12px;">
                <option value="1">Abarrotes</option>
                <option value="2">Bebidas</option>
                <option value="3">Lácteos</option>
                <option value="4">Limpieza</option>
                <option value="5">Aseo Personal</option>
                <option value="6">Panadería</option>
                <option value="7">Frutas y Verduras</option>
            </select>

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Precio (S/)</label>
            <input type="number" name="precio" step="0.10" min="0"
                   value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:12px;">

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:4px;">Stock</label>
            <input type="number" name="stock" min="0"
                   value="<?= htmlspecialchars($_POST['stock'] ?? '') ?>"
                   required style="width:100%;padding:9px;border:1px solid #d7dde6;
                   border-radius:8px;margin-bottom:16px;">

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit"
                        style="background:#0066B3;color:#fff;border:none;font-weight:700;
                               font-size:13px;padding:8px 18px;border-radius:8px;cursor:pointer;">
                    Guardar producto
                </button>
                <a href="index.php?accion=catalogo"
                   style="background:#64748b;color:#fff;text-decoration:none;font-weight:700;
                          font-size:13px;padding:8px 18px;border-radius:8px;display:inline-block;">
                    Volver al Catálogo
                </a>
            </div>

        </form>
    </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>