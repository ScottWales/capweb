<?php
# Controller for the cap interface
require_once('model/model.php');
require_once('model/metadata.php');
require_once('model/config/ini.php');
require_once('view/web.php');
require_once('view/script.php');

session_start();

if (!isset($_SESSION['model'])){
    $model = new Model();
    ReadSectionMetadata($model,'metadata/sections.ini');
    ReadIniConfig($model,'conf/defaults.ini');
    $_SESSION['model']=$model;
} else {
    $model=$_SESSION['model'];
}

if (isset($_POST)){
    $model->LoadPOST($_POST);
}

if (isset($_POST['Submit'])){
    // Create the script
    $scriptview = new ScriptView();
    $scriptview->Display($model);
} else if (isset($_POST['Reset'])) {
    // Reset
    session_unset();
    session_destroy();
    // Refresh page
    header('Location: '.$_SERVER['REQUEST_URI']);
} else {
    // Display on website if not submitted
    $webview = new WebView();
    $webview->Display($model);
}
?>
