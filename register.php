
<?php
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>

<?php
include('lib/common.php');

if ($showQueries) {
    array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

include("register.html");

?>
