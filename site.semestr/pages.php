<?php

class pages
{
    static function s($page, $numberOfPage, $countPage, $countLim = 10)
    {
        if ($countPage < 6) {
            for ($i = 1; $i <= $countPage; $i++) {
                echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
            }
        } else {
            if ($numberOfPage > 4 && $numberOfPage < ($countPage - 4)) {
                for ($i = 1; $i <= 3; $i++) {
                    echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
                }
                echo "...";
                for ($i = $numberOfPage - 1; $i <= $numberOfPage + 1; $i++) {
                    echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
                }
                echo "...";
                for ($i = ($countPage - 2); $i <= $countPage; $i++) {
                    echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
                }
            } else {
                for ($i = 1; $i <= 5; $i++) {
                    echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . $i . '"> ' . $i . ' </a>';
                }
                echo "...";
                for ($i = ($countPage - 4); $i <= $countPage; $i++) {
                    echo '<a class = "page" href = "' . $page . '.php?LIMM=' . $countLim . '&&p=' . (int)$i . '"> ' . (int)$i . ' </a>';
                }
            }
        }
    }
}