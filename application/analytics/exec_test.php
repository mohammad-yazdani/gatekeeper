<?php
$command = "Black_Forest_Monthly";
$result = exec($command);
echo "Results: ".$result."\n";
// TODO : Load download
// $CI =& get_instance();
// $CI->load->helper('download'); 
// $data = file_get_contents($result);
// echo $data;
return $result;
?>