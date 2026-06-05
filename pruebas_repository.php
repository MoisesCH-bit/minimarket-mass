<?php
declare(strict_types=1);
require_once __DIR__ . '/models/ProductoRepository.php';

$repo = new ProductoRepository();

$porNombre    = $repo->buscarPorNombre('Inca');
$porCategoria = $repo->obtenerPorCategoria(2);
$bajoStock    = $repo->obtenerBajoStock(100);
$total        = $repo->contarTotalProductos();

require __DIR__ . '/views/layout/header.php';
?>

<h1>Pruebas del ProductoRepository</h1>

<h2>1. buscarPorNombre('Inca')</h2>
<table>
    <thead>
        <tr><th>Código</th><th>Nombre</th><th>Precio</th><th>Precio con IGV</th><th>Stock</th></tr>
    </thead>
    <tbody>
        <?php foreach ($porNombre as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p->getCodigo()) ?></td>
            <td><?= htmlspecialchars($p->getNombre()) ?></td>
            <td class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
            <td class="precio">S/ <?= number_format($p->precioConIGV(), 2) ?></td>
            <td><?= $p->getStock() ?> unidades</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>2. obtenerPorCategoria(2) — Bebidas</h2>
<table>
    <thead>
        <tr><th>Código</th><th>Nombre</th><th>Precio</th><th>Precio con IGV</th><th>Stock</th></tr>
    </thead>
    <tbody>
        <?php foreach ($porCategoria as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p->getCodigo()) ?></td>
            <td><?= htmlspecialchars($p->getNombre()) ?></td>
            <td class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
            <td class="precio">S/ <?= number_format($p->precioConIGV(), 2) ?></td>
            <td><?= $p->getStock() ?> unidades</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>3. obtenerBajoStock(100)</h2>
<table>
    <thead>
        <tr><th>Código</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>
    </thead>
    <tbody>
        <?php foreach ($bajoStock as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p->getCodigo()) ?></td>
            <td><?= htmlspecialchars($p->getNombre()) ?></td>
            <td class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
            <td <?= $p->getStock() === 0 ? 'class="sin-stock"' : '' ?>>
                <?= $p->getStock() ?> unidades
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>4. contarTotalProductos()</h2>
<p>Total de productos en la BD: <strong><?= $total ?></strong></p>

<?php require __DIR__ . '/views/layout/footer.php'; ?>