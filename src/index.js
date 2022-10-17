
function mostrarEditar(id) {
    let node = document.getElementById(`menu-editar-${id}`)
    let visibility = node.style.visibility;
    node.style.visibility = visibility == "visible" ? 'hidden' : "visible"
}
