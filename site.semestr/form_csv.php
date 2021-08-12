<?php

class form_csv
{
    static function form()
    {
        echo '
        <form enctype="multipart/form-data" action="graph.php" method="POST" id="form_csv">
            <input type="file" name="file">
            <input type="submit" value="Отправить">
        </form>';
    }
}

?>