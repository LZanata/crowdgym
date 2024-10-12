 // Lista de cidades por estado
 const cidadesPorEstado = {
    AC: ["Rio Branco", "Cruzeiro do Sul", "Sena Madureira", "Tarauacá"],
    AL: ["Maceió", "Arapiraca", "Palmeira dos Índios", "Rio Largo"],
    AP: ["Macapá", "Santana", "Laranjal do Jari", "Oiapoque"],
    AM: ["Manaus", "Parintins", "Itacoatiara", "Manacapuru"],
    BA: ["Salvador", "Feira de Santana", "Vitória da Conquista", "Ilhéus"],
    CE: ["Fortaleza", "Juazeiro do Norte", "Sobral", "Crato"],
    DF: ["Brasília"],
    ES: ["Vitória", "Vila Velha", "Serra", "Cariacica"],
    GO: ["Goiânia", "Anápolis", "Aparecida de Goiânia", "Rio Verde"],
    MA: ["São Luís", "Imperatriz", "Caxias", "Timon"],
    MT: ["Cuiabá", "Várzea Grande", "Rondonópolis", "Sinop"],
    MS: ["Campo Grande", "Dourados", "Três Lagoas", "Corumbá"],
    MG: ["Belo Horizonte", "Uberlândia", "Contagem", "Juiz de Fora"],
    PA: ["Belém", "Ananindeua", "Santarém", "Marabá"],
    PB: ["João Pessoa", "Campina Grande", "Patos", "Bayeux"],
    PR: ["Curitiba", "Londrina", "Maringá", "Ponta Grossa"],
    PE: ["Recife", "Olinda", "Caruaru", "Petrolina"],
    PI: ["Teresina", "Parnaíba", "Picos", "Floriano"],
    RJ: ["Rio de Janeiro", "Niterói", "Petrópolis", "Nova Iguaçu"],
    RN: ["Natal", "Mossoró", "Parnamirim", "Caicó"],
    RS: ["Porto Alegre", "Caxias do Sul", "Pelotas", "Santa Maria"],
    RO: ["Porto Velho", "Ji-Paraná", "Ariquemes", "Cacoal"],
    RR: ["Boa Vista", "Rorainópolis", "Caracaraí", "Alto Alegre"],
    SC: ["Florianópolis", "Joinville", "Blumenau", "Chapecó"],
    SP: ["São Paulo", "Barueri", "Osasco", "Jandira"],
    SE: ["Aracaju", "Nossa Senhora do Socorro", "Lagarto", "Itabaiana"],
    TO: ["Palmas", "Araguaína", "Gurupi", "Porto Nacional"]
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

function aplicarMascaraCEP(input) {
    let valor = input.value.replace(/\D/g, ""); // Remove caracteres não numéricos
    if (valor.length > 5) {
        valor = valor.replace(/^(\d{5})(\d)/, "$1-$2"); // Aplica a máscara 00000-000
    }
    input.value = valor;
}