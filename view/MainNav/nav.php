
<nav class="side-menu">
    <ul class="side-menu-list">
        <?php
            require_once("../../models/Usuario.php");
            $usuario = new Usuario();
            $datos = $usuario->get_menu_usuario_rol($_SESSION["rol_id"]);

            foreach ($datos as $row) {
                ?>
                    <li class="blue-dirty">
                        <a href="<?php echo $row['menu_ruta'] ?>">
                            <span class="<?php echo $row['menu_icon'] ?>"></span>
                            <span class="lbl"><?php echo $row['menu_nom'] ?></span>
                        </a>
                    </li>
                <?php
            }
        ?>
    </ul>
</nav>


