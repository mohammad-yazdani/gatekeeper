<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 1:34 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo form_open_multipart(site_url('Test/ClientFiles/upload'));?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>