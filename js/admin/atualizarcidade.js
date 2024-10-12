 // Lista de cidades por estado
 const cidadesPorEstado = {
    AC: ["Rio Branco", "Cruzeiro do Sul", "Sena Madureira"],
    AL: ["Maceió", "Arapiraca", "Palmeira dos Índios"],
    AP: ["Macapá", "Santana", "Laranjal do Jari"],
    AM: ["Manaus", "Parintins", "Itacoatiara"],
    BA: ["Salvador", "Feira de Santana", "Vitória da Conquista"],
    CE: [],
    DF: [],
    ES: [],
    GO: [],
    MA: [],
    MT: [],
    MS: [],
    MG: [],
    PA: [],
    PB: [],
    PR: [],
    PE: [],
    PI: [],
    RJ: [],
    RN: [],
    SP: ["São Paulo", "Campinas", "Santos"],
    RJ: ["Rio de Janeiro", "Niterói", "Petrópolis"]
};

function atualizarCidades() {
    const estadoSelecionado = document.getElementById("estado").value;
    const cidadeSelect = document.getElementById("cidade");
    
    // Limpar as opções de cidade
    cidadeSelect.innerHTML = "<option value=''>Selecione uma cidade</option>";

    // Se um estado foi selecionado, adicionar as cidades correspondentes
    if (estadoSelecionado && cidadesPorEstado[estadoSelecionado]) {
        cidadesPorEstado[estadoSelecionado].forEach(cidade => {
            const option = document.createElement("option");
            option.value = cidade;
            option.text = cidade;
            cidadeSelect.appendChild(option);
        });
    }
}