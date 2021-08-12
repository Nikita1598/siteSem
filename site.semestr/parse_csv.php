<?php

class parse_csv
{
    static function parsing()
    {
        $file = $_FILES['file'];
        if (!isset($file) && file_exists('files_of_graphs/matrix') === false) {
            form_csv::form();
        } else {
            if ((!isset($file) && file_exists('files_of_graphs/matrix')) == false) {
                $filename = basename($file['name']);
                $filesize = $file['size'];
                if ($filesize > 1000000) {
                    return "Файл слишком большой. Загрузите файл размером МЕНЬШЕ 1МБ";
                }
                $filename = explode('.', $filename);
                $filenamesize = sizeof($filename);
                $filename = $filename[$filenamesize - 1];
                if ($filename !== 'csv') {
                    return "Неправильный файл. Загрузите файл в формате csv";
                }
                $ex = mime_content_type($file['tmp_name']);
                if ($ex !== 'text/plain') {
                    return "Что это вы ту присылаете, ну ка не надо такого";
                }
                move_uploaded_file($file['tmp_name'], "files_of_graphs/matrix");
            }

            $fp = file("files_of_graphs/matrix");
            $handle = fopen('files_of_graphs/matrix', 'r');
            $matrix = array(array());
            $column = 0;
            if (($handle = fopen('files_of_graphs/matrix', 'r')) != false) {
                $row = 0;
                while (($data = fgetcsv($handle, 1000, ";")) != false) {
                    $column = count($data);
                    for ($c = 0; $c < $column; $c++) {
                        $matrix[$row][$c] = $data[$c];
                    }
                    $row++;
                }
            }
            if (($handle = fopen('files_of_graphs/matrix', 'r')) != false) {
                while (($data = fgetcsv($handle, 1000, ";")) != false) {
                    $column = count($data);
                    if ($column != $row) {
                        return "Матрица связей должна быть квадратной";
                    }
                }
            }
            for ($i = 0; $i < $row; $i++) {
                for ($j = 0; $j < $column; $j++) {
                    if (preg_match('/[a-z]+/i', $matrix[$i][$j])) {
                        return "В матрице связей должны быть только числа";
                    }
                    if ($i == $j){
                        if ((int)$matrix[$i][$j] != 0){
                            return "На диагоналях матрицы связей должны быть нули";
                        }
                    }
                }
            }
            return $matrix;
        }
    }
}