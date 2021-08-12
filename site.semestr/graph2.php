<?php
include 'page.php';
include 'parse_csv.php';
include 'form_csv.php';

class content implements i_content
{

    function show_content()
    {
        if (isset($_SESSION['user'])) {
            $matrix = parse_csv::parsing();
            if (sizeof($matrix) > 0 && (gettype($matrix) == gettype(array()))) {
//                int dfs(u: int, visited: bool[]):
////    int visitedVertices = 1
////    visited[u] = true                           // помечаем вершину как пройденную
////    for v: uv ∈ E                               // проходим по смежным с u вершинам
////        if not visited[v]                       // проверяем, не находились ли мы ранее в выбранной вершине
////            visitedVertices += dfs(v, visited)
////    return visitedVertices
                $number_of_vertices = sizeof($matrix);
                ?>
                <table id="graph_table" border="1">
                    <caption><b>Матрица связей</b></caption>
                    <thead>
                    <tr>
                        <th>

                        </th>
                        <?php
                        for ($k = 0; $k < $number_of_vertices; $k++) {
                            ?>
                            <th>
                                <?php
                                echo $k + 1;
                                ?>
                            </th>
                            <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0; $i < $number_of_vertices; $i++) {
                        ?>
                        <tr>
                            <th>
                                <?php
                                echo $i + 1;
                                ?>
                            </th>
                            <?php
                            for ($j = 0; $j < $number_of_vertices; $j++) {
                                ?>
                                <td>
                                    <?php
                                    echo $matrix[$i][$j];
                                    ?>
                                </td>
                                <?
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <form action="delete_file.php" id="delete_file" method="post">
                    <input type="submit" value="Удалить данную матрицу связей">
                </form>
                <form id="graph_form" action="graph.php" method="post">
                    <label for="from">Начальная вершина:</label>
                    <input required type="number" name="from" id="from" min="1" max="<?php echo $number_of_vertices ?>"
                           placeholder="Число от 1 до <?php echo $number_of_vertices ?>">
                    <label for="to" id="to_label">Конечная вершина:</label>
                    <input required type="number" name="to" id="to" min="1" max="<?php echo $number_of_vertices ?>"
                           placeholder="Число от 1 до <?php echo $number_of_vertices ?>">
                    <input type="submit" value="Посчтиать наименьший путь">
                </form>
                <?php
                for ($i = 0; $i < $number_of_vertices; $i++) {
                    $matrix_of_vertices[$i] = INF;
                    $matrix_visited_of_vertices[$i] = 1;
                }
                $begin_vertices = $_POST['from'] - 1;
                $begin = $begin_vertices;
                $end = $_POST['to'] - 1;
                if ($end < 0) {
                    ?>
                    <img src='image.php' alt="graph" id="graph_image">
                    <div id="from_to">
                        Введите вершины
                    </div>
                    <?php
                    return;
                }
                $matrix_of_vertices[$begin_vertices] = 0;
                do {
                    $minindex = INF;
                    $min = INF;
                    for ($i = 0; $i < $number_of_vertices; $i++) {
                        if (($matrix_visited_of_vertices[$i] == 1) && ($matrix_of_vertices[$i] < $min)) {
                            $min = $matrix_of_vertices[$i];
                            $minindex = $i;
                        }
                    }
                    if ($minindex != INF) {
                        for ($i = 0; $i < $number_of_vertices; $i++) {
                            if ($matrix[$minindex][$i] > 0) {
                                $temp = $min + $matrix[$minindex][$i];
                                if ($temp < $matrix_of_vertices[$i]) {
                                    $matrix_of_vertices[$i] = $temp;
                                }
                            }
                        }
                        $matrix_visited_of_vertices[$minindex] = 0;
                    }
                } while ($minindex < INF);
                if ($matrix_visited_of_vertices[$end]==1) {
                    echo "<div id=\"from_to\">Такого пути нет, попробуйте другие вершины</div>";
                    ?><img src='image.php' alt="graph" id="graph_image"><?php
                    return false;
                }
                $endd = $end;
                $ver[0] = $end + 1;
                $k = 1;
                $weight = $matrix_of_vertices[$end];
                echo $weight;
                while ($end != $begin_vertices) {
                    for ($i = 0; $i < $number_of_vertices; $i++) {
                        if ($matrix[$end][$i] != 0) {
                            $temp = $weight - $matrix[$end][$i];
                            if ($temp == $matrix_of_vertices[$i]) {
                                $weight = $temp;
                                $end = $i;
                                $ver[$k] = $i + 1;
                                $k++;
                            }
                        }
                    }
                }
                print_r($ver);
                $ver = array_reverse($ver);
                ?>
                <div id="from_to">
                    Из вершины <?php echo $begin + 1 ?> в вершину <?php echo $endd + 1 ?>
                </div>
                <?php
                echo "<div id='weight'>";
                echo "Вес наименьшего пути: " . $matrix_of_vertices[$endd];
                echo "</div>";
                echo "<div id='way'>";
                echo "<br> Путь: ";
                $str='';
                for ($j = 0; $j < sizeof($ver); $j++) {
                    echo $ver[$j];
                    $str .= $ver[$j].",";
                    if ($j < sizeof($ver) - 1) {
                        echo "→";
                    }
                }
                echo "</div>";
                echo "<img src='image.php?ver=".$str."' alt=\"graph\" id=\"graph_image\">"
                ?>
                <?php
            } else {
                echo $matrix;
                if (sizeof($matrix) >= 1) {
                    //unlink("files_of_graphs/matrix");
                    form_csv::form();
                }
            }
            ?>
            <?php
        } else {
            ?>
            <p id="need_to_auth">Пожалуйста авторизируйтесь</p>
            <?php
        }
    }


    function get_title()
    {
        return "Графы";
    }
}

$page = new page(new content());
?>