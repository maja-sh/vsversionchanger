<?php

/**
 * VSChanger
 *
 * Changes version of VS project to VS2010
 *
 * @author     Maja "Wouix" Backman <me@maja.sh>
 * @copyright  2015 Maja Backman
 * @license    https://opensource.org/license/0bsd
 * @version    1.0.0
 * @since      File available since Release 1.2.0
 */

/**
 * Function to convert VS*.* to VS2010
 */
function changeVersion($file) {
    
    // Stuff to force the browser to download the file
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$file['name']);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file['tmp_name']));
    
    // Opens the file
    $handle = fopen($file['tmp_name'], 'r');
    $i = 0;
    
    // Checks whether or not the file could be opened
    if ($handle) {
        // Goes through the file line by line
        while (($buffer = fgets($handle, 4096)) !== false) {
            // Checks if the line number is 1 or 2
            switch ($i) {
                case 1:
                    echo "Microsoft Visual Studio Solution File, Format Version 11.00\r\n";
                    break;
                case 2:
                    echo "# Visual Studio 2010\r\n";
                    break;
                default:
                    echo $buffer;
                    break;
            }
            
            // Increments $i
            $i++;
        }
    } else
        Die("Error reading file!");
}

// Checks if file is submitted
if (isset($_POST['submit'])) {
    changeVersion($_FILES['file']);
} else {
    // Print upload page
    ?>
    <!doctype html>
    <html>
        <head>
            <title>VSVersionChanger</title>
        </head>
        <body>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="file">
                <input type="submit" name="submit" value="Upload">
            </form>
        </body>
    </html>
    <?php
}
