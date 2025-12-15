<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corrida de Carros - Fortune Rat</title>
    
    <link rel="stylesheet" href="app\views\site\easterEgg\fortuneRat.css">
    
    <link rel="shortcut icon" href="/public/assets/img/favicon.png" type="image/x-icon">
</head>
<body>

    <div class="container">
    
        <img src="app\views\site\easterEgg\Gemini_Generated_Image_ncvb5dncvb5dncvb-removebg-preview.png" alt="FortuneRat" id="fotoJogo">
        
        <h1>Saldo: R$ <span id="saldo">1000</span></h1>
        
        <div class="container-pista">
            <div id="resultado" class="resultado-overlay" style="display: none;"></div>

            <svg class="pista-visual" width="350" height="600" viewBox="0 0 350 600">
                <path d="M 175 50 C 340 50 340 280 175 300 C 10 320 10 550 175 550 C 340 550 340 320 175 300 C 10 280 10 50 175 50" 
                      fill="none" stroke="#333" stroke-width="50" stroke-linecap="round"/>
                
                <path d="M 175 50 C 340 50 340 280 175 300 C 10 320 10 550 175 550 C 340 550 340 320 175 300 C 10 280 10 50 175 50" 
                      fill="none" stroke="#FFAD14" stroke-width="2" stroke-dasharray="10, 10"/>
                
                <line x1="175" y1="25" x2="175" y2="75" stroke="white" stroke-width="4" />
            </svg>

            <div id="carro1" class="carro"></div>
            <div id="carro2" class="carro"></div>
            <div id="carro3" class="carro"></div>
            <div id="carro4" class="carro"></div>
            <div id="carro5" class="carro"></div>
        </div>

        <div class="painel-controle">
            
            <div class="inputs-area">
                <div class="input-group">
                    <label>Aposta:</label>
                    <input type="number" id="valorAposta" value="100">
                </div>
                
                <div class="input-group">
                    <label>Carro:</label>
                    <select id="carroEscolhido">
                        <option value="1">Rastros de Pista (Vermelho)</option>
                        <option value="2">Our Garden (Verde)</option>
                        <option value="3">Code Stroll (Rosa)</option>
                        <option value="4">FadeClub (Azul)</option>
                        <option value="5">Bit's Toca (Roxo)</option>
                    </select>
                </div>
            </div>

            <button onclick="iniciarCorrida()" id="btn-jogar">APOSTAR E CORRER</button>

        </div>

    </div>

    <script src="app\views\site\easterEgg\fortuneRat.js"></script>
</body>
</html>