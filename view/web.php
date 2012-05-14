<?php

# Display the config as a web form. All variables must be escaped using htmlspecialchars() before
# being presented

require_once('model/model.php');
require_once('model/config.php');

class Webview {

    /// Display the full page
    public function Display(Model $model){
        echo <<<EOS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-GB">
EOS;
        $this->DisplayHeader($model);
        $this->DisplayBody($model);
        echo <<<EOS
</html>
EOS;
    }

    // Header part
    function DisplayHeader(Model $model){
        echo <<<EOS
    <head>
        <title>Central Ancillary Program</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link type="text/css" href="css/form.css" rel="stylesheet">

        <!--Content from Google CDN http://code.google.com/apis/libraries/devguide.html -->
        <link   type="text/css" 
                href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css" 
                rel="stylesheet">
        <script type="text/javascript" 
                src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"> </script>
        <script type="text/javascript" 
                src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"> </script>
        <script type="text/javascript">
            $(function(){
                $("#section-tabs").tabs();
            });
        </script>
    </head>\n
EOS;
    }

    // Body part & tab structure
    function DisplayBody(Model $model){
        echo <<<EOS
    <body>
        <h2>Central Ancillary Program</h2>
        <form id="cap-form" action="index.php" method="post">
        <div id="section-tabs">
            <ul>\n
EOS;
        foreach($model->sections as $section){
            $key=htmlspecialchars($section->Key());
            $name=htmlspecialchars($section->Name());
            $tooltip=htmlspecialchars($section->Tooltip());
            echo <<<EOS
                <li><a id="tabheading-$key" href="#tab-$key" title="$tooltip">
                    $name
                </a></li>\n
EOS;
        }
        echo <<<EOS
            </ul>\n
EOS;
        array_walk($model->sections,'DisplaySectionCallback',$this);
        echo <<<EOS
        </div>
        <input type="submit" name="Submit" value="Submit"><br>
        <input type="submit" name="Reset" value="Reset"><br>
        </form>
    </body>\n
EOS;
    }

    // Display a section tab
    function DisplaySection(ConfigSection $section,$sectionname){
        $key=htmlspecialchars($section->Key());
        echo <<<EOS
            <div id="tab-$key">
                <fieldset>
                    <legend></legend>\n
EOS;
        array_walk($section->settings,'DisplaySettingCallback',$this);
        echo <<<EOS
                </fieldset>
            </div>\n
EOS;
    }

    // Display a single setting
    function DisplaySetting(ConfigSetting $setting,$settingname){
        echo <<<EOS
            <label  for='input-{$setting->Key()}'
                    title='{$setting->Tooltip()}'
                    >
                    {$setting->Name()}
            </label>
            <input  id='input-{$setting->Key()}' 
                    name='input-{$setting->Key()}'
                    title='{$setting->Tooltip()}'
                    value='{$setting->Value()}'
                    >
            <br>\n
EOS;
    }
};

function DisplaySectionCallback(ConfigSection $section,$sectionname,$class){
    $class->DisplaySection($section,$sectionname);
}
function DisplaySettingCallback(ConfigSetting $setting,$settingname,$class){
    $class->DisplaySetting($setting,$settingname);
}
?>
