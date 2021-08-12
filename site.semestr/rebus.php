<?php
include 'page.php';
set_time_limit(0);

class content implements i_content
{

    function show_content()
    {
        if (isset($_SESSION['user'])) {
            $str = $_POST['text'];
            if (!isset($str)) {
                ?>
                <form action="rebus.php" method="POST" id="form_rebus">
                    <label for="text">Введите выражение</label>
                    <input type="text" id="text" name="text" placeholder="Например: ЛИСА + ВОЛК = ЗВЕРИ" autocomplete="off" required>
                    <input type="submit" value="Нажать сюда">
                </form>
                <?php
            } else {
                $str = mb_strtolower($str);
                $str = mb_ereg_replace('=', '==', $str);
                function replace_all($tex, $let, $rep)
                {
                    for ($i = 0; $i < sizeof($let); $i++) {
                        $tex = mb_ereg_replace($let[$i], $rep[$i], $tex);
                    }
                    $tex = mb_ereg_replace('\+', 'v', $tex);
                    $tex = mb_ereg_replace('==', 'v', $tex);
                    $tex = explode('v', $tex);
                    $tex = (int)$tex[0] . "+" . (int)$tex[1] . "==" . (int)$tex[2];
                    return $tex;
                }

                $exit = array('-', '+', '=', '*', '/', ' ');
//            $exit2 = array('!','@','#','$','%','^','&','*0','(',')',':',',','<','.','>','?',"'", ';','/','|','№','{','}', '`','');
                $str = preg_replace("/[^ a-zа-яё+=*\-\/\d]/ui", "", $str);
//            $str = str_replace($exit2, "", $str);
                $str_g = str_replace($exit, "", $str);
                $str_g = preg_replace("/[^ a-zа-яё\d]/ui", "", $str_g);
                $letters = [];
                function mb_str_split($str)
                {
                    preg_match_all('#.{1}#uis', $str, $out);
                    return $out[0];
                }

                $array = mb_str_split($str_g);
                foreach (array_unique($array) as $char) {
                    array_push($letters, $char);
                }
                if (sizeof($letters) > 10) {
                    print "Ошибка, вы ввели более 10 различных букв";
                } else {
                    $tops = [];
                    $counters = [];
                    for ($i = 0; $i < sizeof($letters); $i++) {
                        array_push($tops, 10 - $i);
                        array_push($counters, 0);
                    }
                    $canExit = false;
                    while (!$canExit) {
                        $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                        $subst = [];
                        for ($i = 0; $i < sizeof($tops); $i++) {
                            array_push($subst, $numbers[$counters[$i]]);
                            unset($numbers[$counters[$i]]);
                            sort($numbers);
                        }
                        $text = replace_all($str, $letters, $subst);
                        $t = false;
                        eval("\$t=(" . $text . ");");
                        if ($t) {
                            $text = mb_ereg_replace('==', '=', $text);
                            print $text . "<br>";
                        }
                        $N = 0;
                        $inc = 1;
                        while ($N < sizeof($counters) and $inc > 0) {
                            $counters[$N] += $inc;
                            $inc = 0;
                            if ($counters[$N] == $tops[$N]) {
                                $counters[$N] = 0;
                                $inc = 1;
                                $N += 1;
                            }
                        }
                        $canExit = true;
                        for ($j = 0; $j < sizeof($tops); $j++) {
                            $canExit &= ($tops[$j] - 1 == $counters[$j]);
                        }
                    }
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
        return "Ребус";
    }

}

$page = new page(new content());