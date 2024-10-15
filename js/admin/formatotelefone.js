function formatPhone(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    if (value.length > 10) {
        input.value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (value.length > 5) {
        input.value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (value.length > 2) {
        input.value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        input.value = value.replace(/^(\d*)/, '($1');
    }
}