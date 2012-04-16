<?php
namespace Cap;

class Webview {
    const SIMPLE=0;
    const ADVANCED=1;

    public function LayoutJS($model){

    }

    public function LayoutTabHeaders($model){
        foreach($model->topsections as $section){
            echo(<<<EOS
                <li><a id='tab-header-{$section->Key()}'
                       href='tab-div-{$section->Key()}'>
                        {$section->Name()}
                </a></li>
EOS
        ); 
        }
    }

    public function LayoutTabs($model){
        foreach($model->topsections as $section){
            echo(<<<EOS
                <div id='tab-div-{$section->Key()}'>
                    <fieldset id='fieldset-{$section->Key()}'>
                        <legend></legend>
EOS
        );
            $this->LayoutForm($section,self::SIMPLE);
            $this->LayoutForm($section,self::ADVANCED);
            echo(<<<EOS
                    </fieldset>
                </div> 
EOS
        );
        }
    }

}

?>
