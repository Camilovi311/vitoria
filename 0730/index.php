<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Mega-Sena</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #E2EAFC;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }
    h1 {
      color: #5fa8d3;
    }
    .numeros {
      display: flex;
      gap: 10px;
      margin: 20px 0;
      flex-wrap: wrap;
      justify-content: center;
    }
    .bola {
      background-color: #ABC4FF;
      color: white;
      font-size: 1.5em;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
    }
    .btn-sortear {
      padding: 10px 20px;
      font-size: 1em;
      background-color: #2980b9;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }
    .btn-sortear:hover {
      background-color: #3498db;
    }
    #formulario {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
      background: #fff;
      padding: 28px 32px 22px 32px;
      border-radius: 16px;
      box-shadow: 0 4px 18px rgba(44, 62, 229, 0.08);
      margin-bottom: 28px;
      border: 1px solid #e0eafc;
    }
    #formulario label {
      font-size: 1.1em;
      color: #2980b9;
      margin-bottom: 2px;
      font-weight: 500;
      letter-spacing: 1px;
    }
    #formulario input {
      padding: 12px 16px;
      margin-bottom: 0;
      border: 1.5px solid #abc4ff;
      border-radius: 8px;
      width: 280px;
      text-align: center;
      font-size: 1.1em;
      background: #f7faff;
      color: #2980b9;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      box-shadow: 0 2px 8px rgba(44, 62, 229, 0.05);
    }
    #formulario input:focus {
      border-color: #5fa8d3;
      box-shadow: 0 2px 12px rgba(44, 62, 229, 0.12);
    }
    .btn-sortear {
      padding: 12px 28px;
      font-size: 1.1em;
      background: linear-gradient(90deg, #2980b9 60%, #6dd5fa 100%);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 1px 2px 8px rgba(41, 128, 185, 0.15);
      font-weight: 600;
      letter-spacing: 1px;
      transition: background 0.2s, transform 0.2s;
      margin-top: 6px;
    }
    .btn-sortear:hover {
      background: linear-gradient(90deg, #3498db 60%, #b3c6ff 100%);
      transform: translateY(-2px) scale(1.04);
    }
    }
  </style>
</head>
<body>
  <?php session_start(); ?>
  <h1>Sorteio da Mega-Sena</h1>
 
  <form id="formulario" method="POST">
    <label for="quantidadeInput" style="margin-bottom: 5px;">Digite a quantidade de bolas:</label>
    <input type="number" id="quantidadeInput" name="quantidade" placeholder="Quantidade entre 6 e 10" min="6" max="10" />
    <button class="btn-sortear" type="submit">Sortear</button>
  </form>

  <div id="probabilidade" style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(44,62,229,0.07); padding:18px 28px; margin-bottom:18px; max-width:400px;">
    <style>
      #probabilidade {
        background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(44,62,229,0.10);
        padding: 24px 32px;
        margin-bottom: 24px;
        max-width: 420px;
        border: 1.5px solid #abc4ff;
        text-align: left;
        font-size: 1.15em;
      }
      #probabilidade strong {
        color: #2980b9;
        font-size: 1.08em;
      }
      #probabilidade .valor {
        color: #24a0daff;
        font-weight: bold;
        font-size: 1.18em;
      }
      #probabilidade .porcento {
        color: #94c4e9ff;
        font-weight: bold;
        font-size: 1.12em;
      }
    </style>
    <?php
      function fatorial($n) {
        return ($n <= 1) ? 1 : $n * fatorial($n - 1);
      }
      function probabilidadeMegaSena($bolas) {
        $total = 60;
        $combinacoes = fatorial($total) / (fatorial($bolas) * fatorial($total - $bolas));
        $prob = 1 / $combinacoes;
        return [$combinacoes, $prob];
      }
      $bolas = 6;
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantidade'])) {
        $entrada = (int)$_POST['quantidade'];
        if ($entrada >= 6 && $entrada <= 10) {
          $bolas = $entrada;
        }
      }
      list($combinacoes, $prob) = probabilidadeMegaSena($bolas);
      echo "<strong>Probabilidade de ganhar:</strong><br>";
      echo "Com $bolas números, a chance de acertar é 1 em <span class='valor'>" . number_format($combinacoes, 0, ',', '.') . "</span>.<br>";
      echo "Ou seja, probabilidade de <span class='porcento'>" . number_format($prob * 100, 10, ',', '.') . "%</span>";
    ?>
  </div>
 

  
  <div class="numeros">
    <?php
      function gerarNumerosUnicos($quantidade, $min = 1, $max = 60) {
          $numerosSorteados = [];
          while (count($numerosSorteados) < $quantidade) {
              $num = rand($min, $max);
              if (!in_array($num, $numerosSorteados)) {
                  $numerosSorteados[] = $num;
              }
          }
          sort($numerosSorteados);
          return $numerosSorteados;
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantidade'])) {
          $entrada = (int)$_POST['quantidade'];
          if ($entrada >= 6 && $entrada <= 10) {
              $resultado = gerarNumerosUnicos($entrada);
              // Salva histórico na sessão
              if (!isset($_SESSION['historico'])) {
                  $_SESSION['historico'] = [];
              }
              array_unshift($_SESSION['historico'], $resultado);
              if (count($_SESSION['historico']) > 3) {
                  $_SESSION['historico'] = array_slice($_SESSION['historico'], 0, 3);
              }
              foreach ($resultado as $numero) {
                  echo "<div class='bola'>$numero</div>";
              }
          }
      }
    ?>
  </div>

  <div id="historico" style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(44,62,229,0.07); padding:18px 28px; margin-bottom:18px; max-width:400px;">
    <h2 style="color:#2980b9; font-size:1.2em; margin-top:0;">Histórico das 3 últimas jogadas</h2>
    <?php
      if (isset($_SESSION['historico']) && count($_SESSION['historico']) > 0) {
          foreach ($_SESSION['historico'] as $idx => $jogada) {
              echo "<div style='margin-bottom:10px;'><strong>Jogo " . ($idx+1) . ":</strong> ";
              foreach ($jogada as $num) {
                  echo "<span style='display:inline-block; background:#abc4ff; color:#fff; border-radius:50%; width:32px; height:32px; line-height:32px; text-align:center; margin-right:4px; font-weight:bold;'>$num</span>";
              }
              echo "</div>";
          }
      } else {
          echo "<em>Nenhuma jogada realizada ainda.</em>";
      }
    ?>
  </div>
</body>
  <footer style="width:100%; background:linear-gradient(90deg, #e0eafc 60%, #cfdef3 100%); color:#2980b9; text-align:center; padding:18px 0; font-size:1.08em; position:fixed; left:0; bottom:0; z-index:10; border-top:1.5px solid #abc4ff; font-weight:500; letter-spacing:1px;">
    &copy; <?php echo date('Y'); ?> - Todos os direitos reservados por Vitória Camilo e Otávio Romio
  </footer>
</html>