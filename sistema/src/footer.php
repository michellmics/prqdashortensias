<style>
  /* Estilo para o container do texto rolante */
  .marquee-container {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    width: 100%; /* Ajusta a largura conforme necessário */
    box-sizing: border-box;
    background-color: #f0f0f0; /* Exemplo de cor de fundo para o marquee */
    padding: 3px 0; /* Espaçamento para o marquee */
  }

  .marquee-container span {
    display: inline-block;
    animation: marquee 20s linear infinite;
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

  /* Estilo do conteúdo abaixo do marquee */
  .footer-info {
    text-align: center;
    font-size: 11px;
    color: #333;
  }

  .footer-info a {
    color: #007bff;
    text-decoration: none;
  }

  .footer-info a:hover {
    text-decoration: underline;
  }
</style>

<footer class="footerNew">
  <!-- Marquee com o conteúdo rolante -->
  <div class="marquee-container">
    <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</span>
  </div>
  
  <!-- Conteúdo abaixo do marquee -->
  <div class="footer-info">
    <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | 
    <b><font color="red"><?php echo $_SESSION['user_nivelacesso']; ?></font></b> | 
    <a href="https://prqdashortensias.com.br/webmail" target="_blank">Webmail</a>
  </div>
</footer>
