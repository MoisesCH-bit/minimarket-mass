<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../auth/barra_usuario.php'; ?>

<h1>Catálogo del Minimarket Mass</h1>
<p>Total de productos: <strong><?= count($productos) ?></strong></p>

<a href="index.php?accion=nuevo-producto" 
   style="display:inline-block;margin-bottom:16px;padding:10px 18px;background:#0066B3;color:#fff;border-radius:8px;text-decoration:none;font-weight:700">
   + Nuevo producto
</a>

<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Precio con IGV</th>
            <th>Stock</th>
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
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>