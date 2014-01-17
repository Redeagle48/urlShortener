<?php
if (isset($_POST['acronym'])) {

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validation expected data exists
    if (!isset($_POST['acronym']) ||
            !isset($_POST['link'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $acronym = $_POST['acronym']; // required
    $link = $_POST['link']; // required

    $error_message = "";

    $site_exp = '~(?:(?(?<=http://|ftp://|https://)(?:http://|ftp://|https://)|)www\.|http://|https://|ftp://)[^\s]+~i';

    //$addHeader = 'http://|ftp://|https://'; //if urls wih http:// or similar
    //(if(!preg_match($addHeader, $link)) {
      //  $link = "http://" . $link;
        //$error_message .= 'The site you entered does not appear to be valid.<br />';
    //}
    
    if (!preg_match($site_exp, $link)) {
        $error_message .= 'The site you entered does not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
    }

    $path = "links.ini";
    //if (!$handle = fopen($path, 'w+')) {
    //  died("Error in the path file");
    //}

    $ini_array = parse_ini_file($path, true);

    //echo 'Antes: ' . print_r($ini_array); echo '</br>';

    $ini_array['links'][$acronym] = $link;
    
    //echo 'Depois: ' . print_r($ini_array); echo '</br>';

    //if (!fwrite($handle, $content)) {
    //return false;
    //}
    //fclose($handle);

    function write_ini_file($assoc_arr, $path, $has_sections = FALSE) {
        $content = "";
        /* Array with multi level */
        if ($has_sections) { 
            foreach ($assoc_arr as $key => $elem) {
                $content .= "[" . $key . "]\n";
                foreach ($elem as $key2 => $elem2) {
                    if (is_array($elem2)) {
                        for ($i = 0; $i < count($elem2); $i++) {
                            $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                        }
                    } else if ($elem2 == "")
                        $content .= $key2 . " = \n";
                    else
                        $content .= $key2 . " = \"" . $elem2 . "\"\n";
                }
            }
        }
        else {
            foreach ($assoc_arr as $key => $elem) {
                //echo $key . ' => ' . $elem;
                if (is_array($elem)) {
                    for ($i = 0; $i < count($elem); $i++) {
                        $content .= $key2 . "[] = \"" . $elem[$i] . "\"\n";
                    }
                } else if ($elem == "")
                    $content .= $key2 . " = \n";
                else
                    $content .= $key2 . " = \"" . $elem . "\"\n";
            }
        }

        if (!$handle = fopen($path, 'w')) {
            die();
            return false;
        }
        if (!fwrite($handle, $content)) {
            die();
            return false;
        }
        fclose($handle);
        return true;
    }
    
    write_ini_file($ini_array,$path, true);
    
    ?>

    <!-- place your own success html below -->

    Thanks.

    <?php
}
die();
?>