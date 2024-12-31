<style>
  /* Estilo para o container do texto rolante */
  .marquee {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    width: 100%; /* Ajusta a largura conforme necessário */
    box-sizing: border-box;
  }

  .marquee span {
    display: inline-block;
    animation: marquee 10s linear infinite;
    white-space: nowrap; /* Garante que o texto não quebre a linha */
  }

  /* Animação para rolar o texto */
  @keyframes marquee {
    0% {
      transform: translateX(100%); /* Começa fora da tela à direita */
    }
    100% {
      transform: translateX(-100%); /* Termina fora da tela à esquerda */
    }
  }
</style>

<footer class="footerNew">
  <div class="marquee">
    <span>adsdasasdgasasjj</span>
  </div>
  <br>
  <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | 
  <b><font color="red"><?php echo $_SESSION['user_nivelacesso']; ?></font></b> | 
  <a href="https://prqdashortensias.com.br/webmail" target="_blank">Webmail</a>
</footer>
