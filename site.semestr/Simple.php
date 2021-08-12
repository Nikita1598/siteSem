<?php
set_time_limit(0);
include "page.php";

class content implements i_content {

    function show_content()
    {
        if (isset($_SESSION['user'])) {
            $simple_number = [];
            $i = 2;
            $g = 500;
            while (sizeof($simple_number) <= $g) {
                $flag = true;
                for ($j = 2; $j < $i; $j++) {
                    if ($i % $j == 0) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag == true) {
                    array_push($simple_number, $i);
                }
                $i++;
            }

            $cols = 20;
            $rows = $g / $cols + 1;
            echo '<table border="2" id="simple_table">';
            $t = 0;
            for ($tr = 1; $tr <= $rows; $tr++) {
                echo '<tr>';
                for ($td = 1; $td <= $cols; $td++) {
                    echo '<td>' . $simple_number[$t] . '</td>';
                    $t++;
                }
                echo '</tr>';
            }
            echo '</table>';


        }else{
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }

    function get_title()
    {
        return "Простые числа";
    }
}

$page = new page(new content());