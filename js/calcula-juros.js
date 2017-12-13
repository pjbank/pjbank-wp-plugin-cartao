function calculaJuros(total, parcelas, juros){

    total = parseFloat(total);
    
    const totalJuros = parseFloat(total * Math.pow((1 + (juros/100)), parcelas));
    
    const totalParcelado = totalJuros / parcelas;
    
    if(parcelas == 1){
        if (juros == 0) {
            return "Sem juros";
        }else{
            return "R$" + totalJuros.toFixed(2);
        }
    }else{
        if(juros == 0){
            return "R$" + totalParcelado.toFixed(2) + " (R$" + totalJuros.toFixed(2) + ")";
        }else{
            return "R$" + totalParcelado.toFixed(2) + " (R$" + totalJuros.toFixed(2) + ")";
        }
    }
}

function retornaTotal(total, parcelas, juros){

    total = parseFloat(total);

    const totalJuros = parseFloat(total * Math.pow((1 + (juros / 100)), parcelas));

    const totalParcelado = totalJuros / parcelas;

    return totalJuros.toFixed(2);
}

function retornaParcela(total, parcelas, juros) {
    
    total = parseFloat(total);

    const totalJuros = parseFloat(total * Math.pow((1 + (juros / 100)), parcelas));

    const totalParcelado = totalJuros / parcelas;

    return totalParcelado.toFixed(2);
}