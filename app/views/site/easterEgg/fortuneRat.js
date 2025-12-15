let saldo = 1000;
let correndo = false;
let posicoes = [100, 97, 94, 91, 88]; 

function atualizarPosicoesVisuais() {
    const carros = [
        document.getElementById('carro1'),
        document.getElementById('carro2'),
        document.getElementById('carro3'),
        document.getElementById('carro4'),
        document.getElementById('carro5')
    ];
    
    for(let i = 0; i < carros.length; i++) {
        carros[i].style.offsetDistance = (posicoes[i] % 100) + '%';
    }
}

window.onload = atualizarPosicoesVisuais;

function iniciarCorrida() {
    if (correndo) return;
    
    document.getElementById('resultado').style.display = 'none';

    const valorApostaInput = document.getElementById('valorAposta');
    const valorAposta = parseInt(valorApostaInput.value);
    const apostaNoCarro = document.getElementById('carroEscolhido').value;

    if (isNaN(valorAposta) || valorAposta > saldo || valorAposta <= 0) {
        alert("Saldo insuficiente ou valor inválido!");
        return;
    }

    saldo -= valorAposta;
    atualizarSaldo();
    correndo = true;

    posicoes = [100, 97, 94, 91, 88];
    atualizarPosicoesVisuais();

    const intervalo = setInterval(() => {
        for(let i = 0; i < 5; i++) {
            posicoes[i] += Math.random() * 1.5; 
        }

        atualizarPosicoesVisuais();

        if (posicoes.some(p => p >= 200)) {
            clearInterval(intervalo);
            correndo = false;
            
            let maxProgresso = Math.max(...posicoes);
            let indexVencedor = posicoes.indexOf(maxProgresso);
            let vencedor = (indexVencedor + 1).toString();
            
            const divResultado = document.getElementById('resultado');

            setTimeout(() => {
                if (vencedor === apostaNoCarro) {
                    const premio = valorAposta * 5;
                    saldo += premio;
                    
                    
                    divResultado.innerHTML = `VOCÊ GANHOU!!<br>+ R$ ${premio}`;
                    divResultado.className = 'resultado-overlay vitoria';
                    divResultado.style.display = 'block';

                } else {
                    
                    divResultado.innerHTML = `VOCÊ PERDEU!<br>Foi muito lento<br>- R$ ${valorAposta}`;
                    divResultado.className = 'resultado-overlay derrota';
                    divResultado.style.display = 'block';
                }
                atualizarSaldo();
            }, 100);
        }
    }, 50);
}

function atualizarSaldo() {
    document.getElementById('saldo').innerText = saldo;
}