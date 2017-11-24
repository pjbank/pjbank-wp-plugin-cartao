function calculaJuros(total, parcelas, juros){

    total = parseFloat(total);
    const qtJuros = parseFloat((total * juros) / 100);
    
    const totalJuros = total + qtJuros;
    
    const totalParcelado = (totalJuros / parcelas);
    
    if(parcelas == 1){
        if (juros == 0) {
            return "Sem juros";
        }else{
            return "Total: R$" + totalJuros.toFixed(2);
        }
    }else{
        if(juros == 0){
            return "Parcelas: R$" + totalParcelado.toFixed(2);        
        }else{
            return "Parcelas: R$" + totalParcelado.toFixed(2);
        }
    }
}

function retornaTotal(total, parcelas, juros){
    total = parseFloat(total);
    const qtJuros = parseFloat((total * juros) / 100);

    const totalJuros = total + qtJuros;

    const totalParcelado = (totalJuros / parcelas);

    return totalJuros.toFixed(2);
}

function retornaParcela(total, parcelas, juros) {
    total = parseFloat(total);
    const qtJuros = parseFloat((total * juros) / 100);

    const totalJuros = total + qtJuros;

    const totalParcelado = (totalJuros / parcelas);

    return totalParcelado.toFixed(2);
}