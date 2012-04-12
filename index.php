<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<?php

require('view/web.php');
require('model/rose/rose.php');

$view = new Cap\Webview();
$model = new Rose\Model();

?>

<html lang="en-GB">
    <head>
        <title>Layout test for CAP interface</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link type="text/css" href="css/form.css" rel="stylesheet">

        <!--Content from Google CDN http://code.google.com/apis/libraries/devguide.html -->
        <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css" rel="stylesheet">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"> </script>

        <script type="text/javascript"> 
            $(function(){
              $("#section-tabs").tabs();
              });

            <?php
                $view->LayoutJS($model);
            ?>
        </script>
    </head>
    <body>
        <form id="cap-form" action="controller/submit.php">

            <fieldset id="user-fieldset"><legend></legend>
                <label title="Email Address" for="user-input-email">Email Address</label>
                <input title="Email Address" id="user-input-email">
                <br>
                <label title="Model Name" for="user-input-model">Model Name</label>
                <input title="Model Name" id="user-input-model">
                <br>
                <input title="Submit" value="Submit" id="submit-button" type="button">
                <br>
            </fieldset>

            <div id="section-tabs">
                <ul>
                    <!-- <li><a id="tab-id" href="#tab-div">tab-name</a></li> -->
                    <?php
                        $view->LayoutTabHeaders($model);
                    ?>
                </ul>

                <!--
                <div id="tab-div">
                    <fieldset><legend></legend>

                        <label></label><input></input><br>

                        <div id="tab-advanced">
                            <h3><a href=#>Advanced</a></h3>
                            <div id="tab-advanced-div">

                                <label></label><input></input><br>

                            </div>
                        </div>
                    </fieldset>
                </div>
                -->
                <?php
                    $view->LayoutTabs($model);
                ?>

            </div>
        </form>
    </body>
</html>


