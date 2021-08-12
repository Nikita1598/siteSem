<?php
require_once "page.php";
include "pages.php";
class content implements i_content
{

    function show_content()
    {
        //   include 'connect.php';
        global $pdo;
        $log_in_ecipient = $_POST['name_2'];
        $content_from_ecipient = $_POST['message'];
        if (isset($log_in_ecipient)) {
            $query_user = "SELECT * FROM `web_prog`.`users` WHERE `users`.`login` = '" . $_SESSION['user'] . "'";
            $query_user = $pdo->query($query_user);
            $query_user = $query_user->fetch(PDO::FETCH_LAZY);
            $query_ecipient = "SELECT * FROM `web_prog`.users WHERE login = '" . $log_in_ecipient . "'";
            $query_ecipient = $pdo->query($query_ecipient);
            $query_ecipient = $query_ecipient->fetch(PDO::FETCH_LAZY);
            if ($query_ecipient['login'] != $log_in_ecipient) {
                echo "<p id='error_message_2'>Такого получателя не существует</p>";
            } else {
                $send = $pdo->exec("INSERT INTO message(`id_of_sender`,`id_of_ecipient`,`message`) VALUES ('" . $query_user['id'] . "','" . $query_ecipient['id'] . "','" . $content_from_ecipient . "')");
                $log_in_ecipient = "";
                $content_from_ecipient = "";
            }
        }
        if ((isset($_SESSION['user']))) {
            ?>
            <p id="new_message">Отправить новое собщение</p>
            <form id="form_chat" action="chat.php" method="POST">
                <label for="name">Login отправителя</label>
                <input type="text" value="<?php echo $_SESSION['user'] ?>" readonly id="name" name="log_in"><br>
                <label for="name_2">Login получателя: </label>
                <input type="text" name="name_2" id="name_2" value="<?php echo $log_in_ecipient ?>" required
                       autocomplete="off"><br>
                <label for="message">Сообщение:</label>
                <textarea type="text" id="message" name="message" required
                          autocomplete="off"><?php echo $content_from_ecipient ?></textarea><br>
                <input type="submit" value="Отправить" id="button_message">
            </form>
            <p id="message_to"> Сообщения для <?php echo $_SESSION['user'] ?>:</p>
            <div id="received_message">
                <?php
                $p = $_GET['p'];
                if (!isset($p)) {
                    $p = 1;
                }
                $query_message = "SELECT * FROM `web_prog`.message WHERE id_of_ecipient = (SELECT id FROM users WHERE login = '" . $_SESSION['user'] . "')";
                $query_message = $pdo->query($query_message);
                $count = 0;
                while ($message = $query_message->fetch(PDO::FETCH_LAZY)) {
                    $user = "SELECT * FROM `web_prog`.users WHERE id = '" . $message['id_of_sender'] . "'";
                    $user = $pdo->query($user);
                    $user = $user->fetch(PDO::FETCH_LAZY);
                    if ($count >= (($p * 10) - 10) && $count < ($p * 10)) {
                        ?>
                        <div class="message">
                        <span class="message_to">
                            от:<br><?php echo $user['login'] ?>
                        </span> <br>
                            ______________________________________________
                            <br>
                            <span class="message_content">
                            сообщение: <br> <?php echo $message['message'] ?>
                        </span>
                        </div>
                        <?php
                    }
                    $count++;
                }
                if ($count >= 10) {
                    $countp = $count / 10;
                    if ($count % 10 > 0) {
                        $countp += 1;
                    }
                    echo '<div class="page_chat">';
                    pages::s('chat', $p, $countp);
//                    for ($i = 1; $i <= $countp; $i++) {
//                        echo '<a class = "page_chat_2" href = "chat.php?&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
                    echo '</div>';
                }
                if ($count === 0) {
                    echo '<p id="no_message">Нет Сообщений</p>';
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }

    function get_title()
    {
        return "Сообщения";
    }

}

$page = new page(new content());