<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/navbar.php'; ?>

<div class="contenedor">
  <?php require __DIR__ . '/../layout/sidebar.php'; ?>

  <main class="contenido">
    <h1>Nueva Venta</h1>

    <?php if (!empty($_GET['error'])): ?>
      <div style="background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;
                  padding:10px;border-radius:8px;margin-bottom:12px;">
        Error al procesar la venta. Verifica los datos.
      </div>
    <?php endif; ?>

<!-- BUSCAR CLIENTE -->
<div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.08);
            padding:20px;margin-bottom:20px;">
  <h3 style="margin:0 0 12px;color:#0066B3;">👤 Cliente</h3>
  <div style="position:relative;display:inline-block;">
    <input type="text" id="input-dni" placeholder="Ingresa el DNI del cliente..."
           maxlength="8" autocomplete="off"
           style="padding:9px 12px;border:1px solid #d7dde6;border-radius:8px;
                  font-size:14px;width:280px;">
    <!-- Dropdown sugerencias -->
    <div id="sugerencias-dni"
         style="display:none;position:absolute;top:100%;left:0;width:100%;
                background:#fff;border:1px solid #d7dde6;border-radius:8px;
                box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:100;max-height:200px;
                overflow-y:auto;"></div>
  </div>
  <div id="info-cliente" style="margin-top:12px;display:none;
       background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:10px;">
  </div>
  <input type="hidden" id="cliente-id" value="">
</div>

    <!-- BUSCAR PRODUCTO -->
<!-- BUSCAR PRODUCTO -->
<div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.08);
            padding:20px;margin-bottom:20px;">
  <h3 style="margin:0 0 12px;color:#0066B3;">📦 Agregar Producto</h3>
  <div style="display:flex;gap:10px;align-items:center;">
    <div style="position:relative;">
      <input type="text" id="input-codigo" placeholder="Código de barras o nombre..."
             autocomplete="off"
             style="padding:9px 12px;border:1px solid #d7dde6;border-radius:8px;
                    font-size:14px;width:280px;">
      <!-- Dropdown sugerencias -->
      <div id="sugerencias-producto"
           style="display:none;position:absolute;top:100%;left:0;width:100%;
                  background:#fff;border:1px solid #d7dde6;border-radius:8px;
                  box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:100;max-height:220px;
                  overflow-y:auto;"></div>
    </div>
    <input type="number" id="input-cantidad" value="1" min="1"
           style="padding:9px;border:1px solid #d7dde6;border-radius:8px;
                  font-size:14px;width:80px;">
    <button onclick="agregarProducto()"
            style="background:#10b981;color:#fff;border:none;padding:9px 16px;
                   border-radius:8px;font-weight:700;cursor:pointer;">
      Agregar
    </button>
  </div>
  <div id="error-producto" style="color:#b91c1c;margin-top:8px;font-size:13px;"></div>
</div>

    <!-- CARRITO -->
    <div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.08);
                padding:20px;margin-bottom:20px;">
      <h3 style="margin:0 0 12px;color:#0066B3;">🛒 Carrito</h3>
      <table id="tabla-carrito" style="width:100%;">
        <thead>
          <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="carrito-body">
          <tr id="carrito-vacio">
            <td colspan="6" style="text-align:center;color:#94a3b8;padding:20px;">
              Aún no hay productos en el carrito
            </td>
          </tr>
        </tbody>
      </table>

      <!-- TOTALES -->
      <div style="margin-top:16px;text-align:right;font-size:14px;">
        <p>Subtotal: <strong id="txt-subtotal">S/ 0.00</strong></p>
        <p>IGV (18%): <strong id="txt-igv">S/ 0.00</strong></p>
        <p style="font-size:18px;color:#0066B3;">
          Total: <strong id="txt-total">S/ 0.00</strong>
        </p>
      </div>
    </div>

    <!-- FINALIZAR VENTA -->
    <div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.08);
                padding:20px;">
      <h3 style="margin:0 0 12px;color:#0066B3;">💳 Método de Pago</h3>
      <div style="display:flex;gap:10px;margin-bottom:16px;">
        <?php foreach (['efectivo','yape','plin','tarjeta'] as $m): ?>
          <label style="cursor:pointer;">
            <input type="radio" name="metodo" value="<?= $m ?>"
                   <?= $m === 'efectivo' ? 'checked' : '' ?>>
            <?= ucfirst($m) ?>
          </label>
        <?php endforeach; ?>
      </div>
      <button onclick="finalizarVenta()"
              style="background:#0066B3;color:#fff;border:none;padding:10px 28px;
                     border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;">
        ✅ Finalizar Venta
      </button>
    </div>

    <!-- Formulario oculto para enviar -->
    <form id="form-venta" method="POST" action="index.php?accion=guardar-venta">
      <input type="hidden" name="cliente_id" id="f-cliente-id">
      <input type="hidden" name="metodo_pago" id="f-metodo-pago">
      <input type="hidden" name="items" id="f-items">
    </form>

  </main>
</div>

<script>
let carrito = [];

// Buscar cliente en tiempo real mientras escribe
let timeoutDni;
document.getElementById('input-dni').addEventListener('input', function() {
    const dni = this.value.trim();
    const sugerencias = document.getElementById('sugerencias-dni');

    clearTimeout(timeoutDni);

    if (dni.length === 0) {
        sugerencias.style.display = 'none';
        limpiarCliente();
        return;
    }

    timeoutDni = setTimeout(() => {
        fetch('index.php?accion=buscar-cliente-ajax&dni=' + encodeURIComponent(dni))
            .then(r => r.json())
            .then(data => {
                if (data.error || !data.id) {
                    sugerencias.style.display = 'none';
                    return;
                }
                // Mostrar sugerencia
                sugerencias.innerHTML = `
                    <div onclick="seleccionarCliente(${data.id}, '${data.dni}', '${data.nombres}', '${data.apellidos}', '${data.tipo_cliente}')"
                         style="padding:10px 14px;cursor:pointer;font-size:14px;border-radius:8px;"
                         onmouseover="this.style.background='#f0f9ff'"
                         onmouseout="this.style.background='#fff'">
                        <strong>${data.nombres} ${data.apellidos}</strong>
                        <span style="color:#64748b;font-size:12px;margin-left:8px;">DNI: ${data.dni} — ${data.tipo_cliente}</span>
                    </div>`;
                sugerencias.style.display = 'block';
            });
    }, 300);
});

function seleccionarCliente(id, dni, nombres, apellidos, tipo) {
    document.getElementById('input-dni').value = dni;
    document.getElementById('cliente-id').value = id;
    document.getElementById('sugerencias-dni').style.display = 'none';

    const div = document.getElementById('info-cliente');
    div.style.display = 'block';
    div.innerHTML = `✅ <strong>${nombres} ${apellidos}</strong> — DNI: ${dni} — Tipo: <em>${tipo}</em>`;
}

function limpiarCliente() {
    document.getElementById('cliente-id').value = '';
    const div = document.getElementById('info-cliente');
    div.style.display = 'none';
    div.innerHTML = '';
}

// Cerrar sugerencias al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!document.getElementById('input-dni').contains(e.target)) {
        document.getElementById('sugerencias-dni').style.display = 'none';
    }
});

// Buscar y agregar producto al carrito
let productoSeleccionado = null;
let timeoutProducto;

document.getElementById('input-codigo').addEventListener('input', function() {
    const termino = this.value.trim();
    const sugerencias = document.getElementById('sugerencias-producto');

    clearTimeout(timeoutProducto);
    productoSeleccionado = null;

    if (termino.length === 0) {
        sugerencias.style.display = 'none';
        return;
    }

    timeoutProducto = setTimeout(() => {
        fetch('index.php?accion=buscar-producto-venta-ajax&codigo=' + encodeURIComponent(termino))
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    sugerencias.style.display = 'none';
                    return;
                }

                sugerencias.innerHTML = data.map(p => `
                    <div onclick="seleccionarProducto(${JSON.stringify(p).replace(/"/g, '&quot;')})"
                         style="padding:10px 14px;cursor:pointer;font-size:14px;border-radius:8px;"
                         onmouseover="this.style.background='#f0f9ff'"
                         onmouseout="this.style.background='#fff'">
                        <strong>${p.nombre}</strong>
                        <span style="color:#64748b;font-size:12px;margin-left:8px;">
                            ${p.codigo_barras} — S/ ${parseFloat(p.precio).toFixed(2)} — Stock: ${p.stock}
                        </span>
                    </div>`).join('');
                sugerencias.style.display = 'block';
            });
    }, 300);
});

function seleccionarProducto(p) {
    productoSeleccionado = p;
    document.getElementById('input-codigo').value = p.codigo_barras;
    document.getElementById('sugerencias-producto').style.display = 'none';
    document.getElementById('input-cantidad').focus();
}

function agregarProducto() {
    const errDiv   = document.getElementById('error-producto');
    const cantidad = parseInt(document.getElementById('input-cantidad').value);
    errDiv.textContent = '';

    if (!productoSeleccionado) {
        errDiv.textContent = 'Selecciona un producto de la lista.';
        return;
    }
    if (cantidad < 1) {
        errDiv.textContent = 'La cantidad debe ser al menos 1.';
        return;
    }
    if (cantidad > productoSeleccionado.stock) {
        errDiv.textContent = `Stock insuficiente. Disponible: ${productoSeleccionado.stock}`;
        return;
    }

    const existente = carrito.find(i => i.producto_id === productoSeleccionado.id);
    if (existente) {
        existente.cantidad += cantidad;
        existente.subtotal  = existente.precio_unitario * existente.cantidad;
    } else {
        carrito.push({
            producto_id:     productoSeleccionado.id,
            codigo_barras:   productoSeleccionado.codigo_barras,
            nombre:          productoSeleccionado.nombre,
            precio_unitario: parseFloat(productoSeleccionado.precio),
            cantidad:        cantidad,
            subtotal:        parseFloat(productoSeleccionado.precio) * cantidad,
        });
    }

    document.getElementById('input-codigo').value   = '';
    document.getElementById('input-cantidad').value = '1';
    productoSeleccionado = null;
    renderCarrito();
}

// Cerrar sugerencias al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!document.getElementById('input-codigo').contains(e.target)) {
        document.getElementById('sugerencias-producto').style.display = 'none';
    }
});

// Eliminar item del carrito
function quitarItem(index) {
    carrito.splice(index, 1);
    renderCarrito();
}

// Renderizar tabla del carrito
function renderCarrito() {
    const tbody = document.getElementById('carrito-body');

    if (carrito.length === 0) {
        tbody.innerHTML = `<tr id="carrito-vacio">
            <td colspan="6" style="text-align:center;color:#94a3b8;padding:20px;">
                Aún no hay productos en el carrito
            </td></tr>`;
        actualizarTotales(0);
        return;
    }

    let html = '';
    let subtotal = 0;

    carrito.forEach((item, i) => {
        subtotal += item.subtotal;
        html += `<tr>
            <td>${item.codigo_barras}</td>
            <td>${item.nombre}</td>
            <td>S/ ${item.precio_unitario.toFixed(2)}</td>
            <td>${item.cantidad}</td>
            <td>S/ ${item.subtotal.toFixed(2)}</td>
            <td>
                <button onclick="quitarItem(${i})"
                        style="background:#ef4444;color:#fff;border:none;padding:3px 8px;
                               border-radius:6px;cursor:pointer;font-size:12px;">
                    ✕
                </button>
            </td>
        </tr>`;
    });

    tbody.innerHTML = html;
    actualizarTotales(subtotal);
}

function actualizarTotales(subtotal) {
    const igv   = subtotal * 0.18;
    const total = subtotal + igv;
    document.getElementById('txt-subtotal').textContent = 'S/ ' + subtotal.toFixed(2);
    document.getElementById('txt-igv').textContent      = 'S/ ' + igv.toFixed(2);
    document.getElementById('txt-total').textContent    = 'S/ ' + total.toFixed(2);
}

// Finalizar y enviar la venta
function finalizarVenta() {
    const clienteId = document.getElementById('cliente-id').value;
    const metodo    = document.querySelector('input[name="metodo"]:checked').value;

    if (!clienteId) { alert('Primero busca y selecciona un cliente.'); return; }
    if (carrito.length === 0) { alert('El carrito está vacío.'); return; }

    document.getElementById('f-cliente-id').value  = clienteId;
    document.getElementById('f-metodo-pago').value = metodo;
    document.getElementById('f-items').value       = JSON.stringify(carrito);
    document.getElementById('form-venta').submit();
}

// Permitir buscar con Enter en el campo de código
document.getElementById('input-codigo').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') agregarProducto();
});
document.getElementById('input-dni').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') buscarCliente();
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>