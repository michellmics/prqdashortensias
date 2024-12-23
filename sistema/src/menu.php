<style>
/* Estilo geral para o menu */
.nav.menu {
    list-style: none;
    padding: 0;
    margin: 0;
    color: black; /* Texto preto para o menu principal */
}

.nav.menu li {
    display: inline-block;
    position: relative; /* Necessário para posicionar o submenu corretamente */
}

.nav.menu li a {
    color: white;
    padding: 15px;
    text-decoration: none;
    display: block;
}

/* Estilo do submenu */
.submenu {
    position: absolute;
    top: 0;
    left: 100%; /* O submenu aparecerá ao lado do item pai */
    background-color: black; /* Cor de fundo preta */
    color: white; /* Texto branco */
    display: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Sombra para destacar o submenu */
    z-index: 1000; /* Garante que o submenu ficará por cima dos outros elementos */
}

/* Mostrar o submenu quando o item pai for hover ou ativo */
.nav.menu li:hover .submenu,
.nav.menu li:focus-within .submenu {
    display: block;
}

/* Estilo para o submenu, quando ele for aberto */
.submenu li {
    display: block;
}

/* Responsivo: Ajuste para dispositivos móveis */
@media (max-width: 768px) {
    .nav.menu li {
        display: block; /* Cada item do menu será exibido em uma linha */
    }

    .submenu {
        position: absolute;
        top: -10px; /* Ajusta para sobrepor o menu principal */
        left: 0; /* Alinha o submenu com o item pai */
        width: 100%; /* O submenu ocupa toda a largura do item pai */
        z-index: 1000; /* Certifica-se de que o submenu aparece por cima */
    }

    /* Ajusta o estilo do submenu para dispositivos móveis */
    .submenu li {
        padding: 10px;
    }

    /* Estilo de link do submenu */
    .submenu li a {
        padding: 10px 15px;
        color: white;
        text-decoration: none;
        display: block;
    }
}




</style>

<nav class="navigation">
    <ul class="nav menu">
        <li><a href="index.php">Inicio</a></li>
        <li>
            <a href="#">Administração</a>
            <ul class="submenu">
                <li><a href="morador_table.php">Moradores</a></li>
                <li><a href="https://prqdashortensias.com.br/webmail" target="_blank">WebMail</a></li>
            </ul>
        </li>
        <li><a href="lista_table.php">Minha Lista de Convidados</a></li>
        <li><a href="morador_form_edit_profile.php">Minha Conta</a></li>
        <li><a href="../logoff.php">Sair</a></li>
    </ul>
</nav>