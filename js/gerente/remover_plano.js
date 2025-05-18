function confirmarRemocao(id) {
    if (confirm("Tem certeza de que deseja remover este plano?")) {
        window.location.href = "../php/gerente/remover_plano.php?id=" + id;
    }
}
