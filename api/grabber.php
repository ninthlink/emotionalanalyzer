<?php
if ( isset( $_POST['u'] ) ) {
//echo $_POST['u'];
// http://stackoverflow.com/a/14999705 so simple
echo file_get_contents($_POST['u']);
} else {
echo 'testing...';
}
?>
