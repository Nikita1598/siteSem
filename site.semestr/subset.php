<?php

include "page.php";

class content implements i_content
{
    public $g = "";
    public $fl = true;
    public $t = [];

    function show_content($d = 1, $num = 0, $s = '')
    {
        if (isset($_SESSION['user'])) {
            $n = $_POST['number1'];
            if (!isset($n)) {
                ?>
                <form action="subset.php" method="POST" id="subset_form">
                    <label for="number1">Введите число</label>
                    <input type="number" id="number1" name="number1" placeholder="Введите число от 1 до 16" min="1"
                           max="16">
                    <input type="submit" value="Нажать сюда">
                </form>
                <?php
            } else {
                $m[] = '';
                for ($i = 1; $i <= $n; $i++) {
                    $m[] = $i;
                }
                $d = $m;
                if ($num == sizeof($d)) {
                } else {
                    content::show_content($d, $num + 1, $s);
                    $s = $s . $d[$num];
                    if ($s == "") {
                        $this->fl = false;
                        print "<br>ø";
                        sort($this->t);
                        for ($i = 0; $i < sizeof($this->t); $i++) {
                            print ",<br>" . $this->t[$i];
                        }
                    }
                    if ($this->fl == true) {
                        array_push($this->t, $s);
                    }
                    content::show_content($d, $num + 1, $s);
                }
            }
        } else {
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }

    function get_title()
    {
        return "Подмножества";
    }
}

$page = new page(new content());