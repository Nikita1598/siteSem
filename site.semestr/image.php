<?php
include "parse_csv.php";

class image
{
    public function __construct()
    {
        header("Content-Type: image/png");
        $matrix = parse_csv::parsing();
        $str = $_GET['ver'];
        $str = explode(',', $str);
        $number_of_vertices_to_use = count($str) - 1;
        $number_of_vertices = count($matrix);
        $image = imagecreate(250, $number_of_vertices/3*100);

        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 0, 0, 255);
        $red = imagecolorallocate($image, 255, 0, 0);
        $green = imagecolorallocate($image, 0, 255, 0);
        $lightgreen = imagecolorallocate($image, 14, 50, 190);

        imagefill($image, 0, 0, $lightgreen);
        imagesetthickness($image, 5);
        $j = -1;
        for ($i = 0; $i < $number_of_vertices; $i++) {
            $x_vertices[$i] = $i % 3 * 80 + 40;
            if ($i % 3 == 0) {
                $j++;
            }
            $y_vertices[$i] = $j * 100 + 40;
        }
        for ($i = 0; $i < $number_of_vertices; $i++) {
            for ($j = 0; $j < $number_of_vertices; $j++) {
                if ($matrix[$i][$j] != 0) {
                    imageline($image, $x_vertices[$i], $y_vertices[$i], $x_vertices[$j], $y_vertices[$j], $black);
                }
            }
        }
        for ($i = 0; $i < $number_of_vertices_to_use; $i++) {
            if ($str[$i+1] != '') {
                imageline($image, $x_vertices[$str[$i]-1], $y_vertices[$str[$i]-1], $x_vertices[$str[$i + 1]-1], $y_vertices[$str[$i + 1]-1], $green);
            }
        }
        for ($i = 0; $i < $number_of_vertices; $i++) {
            imagefilledellipse($image, $x_vertices[$i], $y_vertices[$i], 50, 50, $red);
            imagestring($image, 5, $x_vertices[$i], $y_vertices[$i], $i + 1, $black);
        }

        imagepng($image);

        imagedestroy($image);
    }
}

new image();