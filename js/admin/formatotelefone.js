function formatTel(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número

    // Evita forçar a formatação se o campo estiver sendo apagado
    if (input.value.length < input.oldValue?.length) {
        input.oldValue = input.value; // Salva o valor antigo para a próxima comparação
        return;
    }

    if (value.length > 10) {
        input.value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (value.length > 5) {
        input.value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (value.length > 2) {
        input.value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        input.value = value.replace(/^(\d*)/, '($1');
    }

    input.oldValue = input.value; // Salva o valor atual para a próxima comparação
}