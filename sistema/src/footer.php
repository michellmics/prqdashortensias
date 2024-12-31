<style>
  /* Estilo para o texto rolante */
  .marquee {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    width: 100%; /* Ajusta o tamanho conforme necessário */
    box-sizing: border-box;
  }

  .marquee span {
    display: inline-block;
    animation: marquee 10s linear infinite;
  }

  /* Animação para rolar o texto */
  @keyframes marquee {
    0% {
      transform: translateX(100%);
    }
    100% {
      transform: translateX(-100%);
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
