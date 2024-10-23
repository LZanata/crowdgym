// Função para ocultar a mensagem após 3 segundos
setTimeout(function () {
  var mensagem = document.getElementById("mensagem-sucesso");
  if (mensagem) {
    mensagem.style.display = "none";
  }
}, 3000); // 3000 milissegundos = 3 segundos
