<style>
    /* Estilo básico para o menu */
.nav.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav.menu > li {
    display: inline-block;
    position: relative;
}

.nav.menu a {
    text-decoration: none;
    padding: 10px 15px;
    display: block;
}

/* Estilo para o submenu */
.submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    top: 100%;
    left: 0;
    display: none; /* Submenu oculto por padrão */
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
}

.submenu li {
    display: block;
}

.submenu a {
    padding: 10px 15px;
    white-space: nowrap;
}

/* Mostrar submenu ao passar o mouse */
.nav.menu > li:hover .submenu {
    display: block;
}

</style>

<nav class="navigation">
    <ul class="nav menu">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="morador_table.php">Moradores</a></li>
        <li><a href="lista_table.php">Minha Lista de Convidados</a></li>
        <li><a href="morador_form_edit_profile.php">Minha Conta</a></li>
        <li>
            <a href="#">Administração</a>
            <ul class="submenu">
                <li><a href="https://prqdashortensias.com.br/webmail" target="_blank">WebMail</a></li>
            </ul>
        </li>
        <li><a href="../logoff.php">Sair</a></li>
    </ul>
</nav>