<style>
/* Footer superior */
.footerUpper {
  background-color: #e6e6e6; /* Cinza claro */
  color: #333; /* Texto escuro */
  font-size: 14px; /* Fonte ligeiramente maior */
  text-align: center; /* Centraliza o texto */
  padding: 10px 0; /* Espaçamento interno */
  margin: 0; /* Remove margem externa */
  width: 100%; /* Largura total */
  border-bottom: 1px solid #ccc; /* Linha separadora opcional */
}

/* Footer inferior */
.footerNew {
  background-color: #f0f0f0; /* Cinza mais claro */
  color: #000; /* Texto preto */
  font-size: 12px; /* Fonte menor */
  text-align: center; /* Centraliza o texto */
  padding: 10px 0; /* Espaçamento interno */
  margin: 0; /* Remove margem externa */
  width: 100%; /* Largura total */
  border-top: 1px solid #ccc; /* Linha separadora opcional */
}
</style>


<footer class="footerUpper">
  <p>Informações adicionais no footer superior</p>
</footer>
<footer class="footerNew">
  <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | 
  <b><font color="red"><?php echo $_SESSION['user_nivelacesso']; ?></font></b> | 
  <a href="https://prqdashortensias.com.br/webmail" target="_blank">Webmail</a>
</footer>