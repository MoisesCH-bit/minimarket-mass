<?php $accionActual = $_GET['accion'] ?? 'catalogo'; ?>
<aside class="sidebar">
    <a href="index.php?accion=catalogo"
       class="sidebar-item <?= $accionActual === 'catalogo' ? 'activo' : '' ?>">
        📦 Catálogo
    </a>
    <a href="index.php?accion=nuevo-producto"
       class="sidebar-item <?= $accionActual === 'nuevo-producto' ? 'activo' : '' ?>">
        ➕ Nuevo producto
    </a>
    <a href="index.php?accion=reporte-pdf"
       target="_blank">
        📊 Reportes
    </a>
    <a href="index.php?accion=nueva-venta"
   class="sidebar-item <?= $accionActual === 'nueva-venta' ? 'activo' : '' ?>">
    🛒 Nueva Venta
</a>
        <a href="index.php?accion=clientes"
       class="sidebar-item <?= $accionActual === 'clientes' ? 'activo' : '' ?>">
        👥 Clientes
    </a>
</aside>
