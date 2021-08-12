<?php
include "page.php";

class content implements i_content
{

    function show_content()
    {
        if (isset($_SESSION['user'])) {
            ?>
            <p id="need_to_auth">Привет <?php echo $_SESSION['user'] ?></p>
            <?php
        } else {
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }

    function get_title()
    {
        return "Добро пожаловать";
    }
}

$page = new page(new content());