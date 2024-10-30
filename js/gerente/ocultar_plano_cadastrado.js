// Esconde a mensagem após 5 segundos
setTimeout(function() {
    const mensagemSucesso = document.querySelector('.mensagem-sucesso');
    if (mensagemSucesso) {
        mensagemSucesso.style.transition = 'opacity 0.5s';
        mensagemSucesso.style.opacity = '0';
        setTimeout(() => mensagemSucesso.remove(), 500); // Remove completamente após fade-out
    }
}, 2000); // 2000 ms = 2 segundos