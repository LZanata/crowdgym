function confirmarRemocao(id) {
    if (confirm("Tem certeza de que deseja remover este usuário?")) {
        // Redireciona para a página de remoção caso o usuário confirme
        window.location.href = "php/gerente/remover_func.php?id=" + id;
    }
}