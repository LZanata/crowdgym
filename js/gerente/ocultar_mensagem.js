// Função para ocultar a mensagem após 3 segundos
setTimeout(function () {
  var mensagem = document.getElementById("mensagem-sucesso");
  if (mensagem) {
    mensagem.style.display = "none";
  }
}, 2000); // 2000 milissegundos = 2 segundos
