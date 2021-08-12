<?php
include "page.php";
include "pages.php";
class content implements i_content
{
    function show_content()
    {
        if (isset($_SESSION['user'])) {
            $file = $_FILES['file'];
            if (!isset($file) && file_exists('#') === false) {
                ?>
                <form enctype="multipart/form-data" action="csv.php" method="POST" id="form_csv">
                    <input type="file" name="file">
                    <input type="submit" value="Отправить">
                </form>
                <?php
            } else {
                if ((!isset($file) && file_exists('#')) == false) {
                    $filename = basename($file['name']);
                    $filesize = $file['size'];
                    if ($filesize > 1000000) {
                        echo("Файл слишком большой. Загрузите файл размером МЕНЬШЕ 1МБ");
                        return false;
                    }
                    $filename = explode('.', $filename);
                    $filenamesize = sizeof($filename);
                    $filename = $filename[$filenamesize - 1];
                    if ($filename !== 'csv') {
                        echo("Неправильный файл. Загрузите файл в формате csv");
                        return false;
                    }
                    $ex = mime_content_type($file['tmp_name']);
                    if ($ex !== 'text/plain') {
                        echo("Ой, кажется что то пошло не так");
                        return false;
                    }
                    move_uploaded_file($file['tmp_name'], "#");
                }
                echo '<form action="csv.php" method="get" id="select">
                     <select name="LIMM">
                        <option name="Lim" value="10">10</option>
                        <option value="20" name="Lim">20</option>
                        <option value="50" name="Lim">50</option>
                        <option value="100" name="Lim">100</option>
                     </select>
                     <input type="submit">
                  </form>';
                $countLim = $_GET['LIMM'];
                if ($countLim === NULL) {
                    $countLim = 10;
                }
                $fp = file("#");
                $countTT = count($fp);
                $countPage = $countTT / $countLim;
                $countD = ($countTT - 1) % $countLim;
                if ($countD > 0) {
                    $countPage = (int)$countPage + 1;
                }
                $numberOfPage = $_GET['p'];
                $visibleContent = $countLim * $numberOfPage;
                if (isset($numberOfPage)) {
                    $visibleContent = $visibleContent - $countLim;
                }
                echo '<div id="pages_1">';
                pages::s('csv',$numberOfPage,$countPage,$countLim);
                echo '</div>';
//                echo '<div id="pages_1">';
//                if ($numberOfPage > 4 && $numberOfPage < ($countPage - 4)) {
//                    for ($i = 1; $i <= 3; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//                    for ($i = $numberOfPage - 1; $i <= $numberOfPage + 1; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//                    for ($i = ($countPage - 2); $i <= $countPage; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
//                    }
//                } else {
//                    for ($i = 1; $i <= 5; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//
//                    for ($i = ($countPage - 4); $i <= $countPage; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
//                    }
//                }
//                echo '</div>';
                $handle = fopen('#', 'r');
                $data = fgetcsv($handle, 1000, ",");
                //$num = count($data);
                echo '<table id="csv_table" border="3" style="border-color: white"><tr><td>№</td><td>' . $data[0] . '</td><td>' . $data[1] . '</td><td>' . $data[2] . '</td><td>' . $data[3] . '</td></tr>';
                if (($handle = fopen('#', 'r')) !== false) {
                    $count = 1;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        if (($count > $visibleContent + 1) && $count < ($visibleContent + $countLim + 2)) {
                            echo('<tr><td>' . ($count - 1) . '</td>');
                            for ($c = 0; $c < $num; $c++) {
                                echo "<td>" . htmlentities($data[$c]) . "</td>";
                            }
                        }
                        $count++;
                        echo('</tr>');
                    }
                    fclose($handle);
                }
                echo '</table>';
                echo '<div id="pages_2">';
                pages::s('csv',$numberOfPage,$countPage,$countLim);
//                if ($numberOfPage > 4 && $numberOfPage < ($countPage - 4)) {
//                    for ($i = 1; $i <= 3; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//                    for ($i = $numberOfPage - 1; $i <= $numberOfPage + 1; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//                    for ($i = ($countPage - 2); $i <= $countPage; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
//                    }
//                } else {
//                    for ($i = 1; $i <= 5; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
//                    }
//                    echo "...";
//
//                    for ($i = ($countPage - 4); $i <= $countPage; $i++) {
//                        echo '<a class = "page" href = "csv.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
//                    }
//                }
                echo '</div>';
            }
        } else {
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }

    function get_title()
    {
        return "CSV Таблица";
    }
}

$page = new page(new content());