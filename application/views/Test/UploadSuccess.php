<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/1/2017
 * Time: 2:17 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>

<!-- <ul>
<?php foreach ($upload_data as $item => $value):?>
    <li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul> -->

<p><?php echo anchor('upload', 'Upload Another File!'); ?></p>

</body>
</html>