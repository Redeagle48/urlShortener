<?php
if(isset($_POST['acronym'])) {
     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['acronym']) ||
        !isset($_POST['link'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
     
    $acronym = $_POST['acronym']; // required
    $link = $_POST['link']; // required
     
    $error_message = "";
    
    $site_exp = '/^./';
    $site_exp = '~(?:(?(?<=http://|ftp://|https://)(?:http://|ftp://|https://)|)www\.|http://|https://|ftp://)[^\s]+~i';
  
  if(!preg_match($site_exp,$link)) {
    $error_message .= 'The site you entered does not appear to be valid.<br />';
  }

  if(strlen($error_message) > 0) {
    died($error_message);
  }

  $path = "links.ini";
  if (!$handle = fopen($path, 'w+')) {
        died("Error in the path file");
  }
    
  $ini_array = parse_ini_file($path,true);
    
  $content[$acronym] = $link;
  
  if (!fwrite($handle, $content)) { 
        return false; 
  } 
  fclose($handle);
  
  
  
?>
 
<!-- place your own success html below -->
 
Thanks.
 
<?php
}
die();
?>