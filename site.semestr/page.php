<?php
require_once 'connect.php';

interface i_content
{
    function show_content();
    function get_title();
}

class page
{

    private $content;

    public function __construct($content)
    {
        if ($content instanceof i_content) {
            $this->content = $content;
            $this->show_head();
            $this->show_menu();
            $this->show_title();
            $content->show_content();
            $this->show_footer();
            $this->show_auth_form();
            $this->show_registration_form();
        }
    }

    private function show_head()
    {
        ?>
        <!DOCTYPE html>
        <html lang='ru'>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $this->content->get_title(); ?></title>
            <link rel="stylesheet" href="css/webfonts/all.css">
            <link rel="stylesheet" href="css/bootstrap.css">
            <link rel="stylesheet" href="css/style.css">
            <script rel="script" src="script/bootstrap.bundle.js"></script>
            <script rel="script" src="script/jquery.js"></script>
            <script rel="script" src="script/script.js"></script>
        </head>
        <?php
    }

    private function show_title()
    {
        echo "<h1 class='main_text'>{$this->content->get_title()}</h1>";
        echo "<section class='content'>";
    }

    private function show_menu()
    {
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">WEB-Программирование</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Simple.php">Простые числа</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="subset.php">Подмножества</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rebus.php">Ребус</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="csv.php">CSV Таблица</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat.php">Сообщения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="graph.php">Графы</a>
                    </li>
                    <li class="nav-item" id="auth">
                        <?php
                        if (!isset($_SESSION['user'])) {
                            ?>
                            <a class="nav-link" onclick="open_form()">Войти</a>
                            <?php
                        }  ?>
                    </li>
                    <li class="nav-item" id="registration">
                        <?php
                        if (!isset($_SESSION['user'])) {
                            ?>
                            <a class="nav-link" onclick="open_form_registration()">Регистрация</a>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link" href="logout.php"><?php echo $_SESSION['user'] ?></a>
                        <?php }?>
                    </li>
                </ul>
            </div>
        </nav>
        <?php

    }

    private function show_footer()
    {
        ?>
        </section>
        <footer class="footer">

        </footer>
        </body>
        </html>
        <?php
    }

    private function show_auth_form()
    {
        ?>
        <div id="background_auth_form">
            <div class="auth_form">
                <form>
                    <p class="auth_p">Вход</p>
                    <i class="fas fa-times" onclick="close_form()"></i>
                    <div class="form-group">
                        <label for="user">Логин </label>
                        <input type="text" class="form-control" id="user" name="user" required autocomplete="off"
                               placeholder="Введите логин">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль </label>
                        <input type="password" class="form-control" id="password" name="password" required
                               autocomplete="new-password" placeholder="Введите пароль">
                    </div>
                    <p id="error_message"></p>
                    <div class="btn btn-primary" onclick="auth()">Войти</div>
                </form>
            </div>
        </div>
        <?php
    }

    private function show_registration_form()
    {
        ?>
        <div id="background_registration_form">
            <div class="registration_form">
                <form>
                    <p class="registration_p">Регистрация</p>
                    <i class="fas fa-times" onclick="close_form_registration()"></i>
                    <div class="form-group">
                        <label for="user1">Логин </label>
                        <input type="text" class="form-control" id="user1" name="user1" required autocomplete="off"
                               placeholder="Введите логин">
                    </div>
                    <div class="form-group">
                        <label for="email">e-mail </label>
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="off"
                               placeholder="Введите e-mail">
                    </div>
                    <div class="form-group">
                        <label for="password1">Пароль </label>
                        <input type="password" class="form-control" id="password1" name="password1" required
                               autocomplete="new-password" placeholder="Введите пароль">
                    </div>
                    <div class="form-group">
                        <label for="repeat_password">Повторите пароль </label>
                        <input type="password" class="form-control" id="repeat_password" name="repeat_password" required
                               autocomplete="new-password" placeholder="Повторите пароль">
                    </div>
                    <p id="error_message_reg"></p>
                    <div class="btn btn-primary" onclick="registration()">Зарегистрироваться</div>
                </form>
            </div>
        </div>
        <?php
    }


}

?>