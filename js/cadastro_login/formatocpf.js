function formatCPF(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    if (value.length > 9) {
        input.value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
    } else if (value.length > 6) {
        input.value = value.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
    } else if (value.length > 3) {
        input.value = value.replace(/^(\d{3})(\d{0,3})/, '$1.$2');
    } else {
        input.value = value;
    }
}