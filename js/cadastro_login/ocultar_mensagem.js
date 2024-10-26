// Função para ocultar a mensagem de erro após 2 segundos
function ocultarMensagem() {
  setTimeout(function () {
    var mensagemErro = document.getElementById("mensagemErro");
    if (mensagemErro) {
      mensagemErro.style.display = "none";
    }
  }, 2000); // 2000 milissegundos = 2 segundos
}
