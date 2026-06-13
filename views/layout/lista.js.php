<script>
function abrirModal(codigo, nombre) {
    document.getElementById('modal-texto').textContent = 'Vas a desactivar: ' + nombre;
    document.getElementById('modal-confirmar').href = 'index.php?accion=eliminar-producto&codigo=' + codigo;
    document.getElementById('modal-eliminar').classList.add('activo');
    document.body.style.overflow = 'hidden';
}
function cerrarModal() {
    document.getElementById('modal-eliminar').classList.remove('activo');
    document.body.style.overflow = '';
}
document.getElementById('modal-eliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>