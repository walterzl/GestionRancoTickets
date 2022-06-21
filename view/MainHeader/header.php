<header class="site-header">
    <div class="container-fluid">

        <a href="..\Home\" class="site-logo">
            <img class="hidden-md-down" src="../../public/img/logoweb.png" alt="logo-ranco">
            <img class="hidden-lg-up" src="../../public/img/logoweb.png" alt="logo-ranco">
        </a>

        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>

        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <div class="dropdown user-menu">
                    <a class="dropdown-item" href="../Logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                        <!-- <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../../public/<?php echo $_SESSION["rol_id"] ?>.jpg" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="../Logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                        </div> -->
                    </div>
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="user_idx" value="<?php echo $_SESSION["usu_id"] ?>"><!-- ID del Usuario-->
                <input type="hidden" id="rol_idx" value="<?php echo $_SESSION["rol_id"] ?>"><!-- Rol del Usuario-->
                <input type="hidden" id="grupo_idx" value="<?php echo $_SESSION["grupo_id"] ?>"><!-- Grupo del Usuario-->
                <input type="hidden" id="area_idx" value="<?php echo $_SESSION["area_id"] ?>"><!-- Area del Usuario-->
                <input type="hidden" id="suba_idx" value="<?php echo $_SESSION["suba_id"] ?>"><!-- Sub Area del Usuario-->
                <input type="hidden" id="sis_idx" value="<?php echo $_SESSION["sis_id"] ?>"><!-- Sistema del Usuario-->

                <div class="dropdown dropdown-typical">
                    <a href="#" class="dropdown-toggle no-arr">
                        <span class="font-icon font-icon-home" style="color:#FF0000;"></span>
                        <span class="lblcontactonomx" style="color:#FF0000" >SISOR - <?php echo $_SESSION["sis_nom"] ?></span>
                    </a>

                    </br>
                    <a href="#" class="dropdown-toggle no-arr">
                        <span class="font-icon font-icon-user"></span>
                        <span class="lblcontactonomx"><?php echo $_SESSION["usu_nom"] ?> <?php echo $_SESSION["usu_ape"] ?></span>
                    </a>
                    </br>

                </div>

            </div>
        </div>
    </div>
</header>