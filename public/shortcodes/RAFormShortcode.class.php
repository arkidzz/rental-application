<?php
class RAFormShortcode extends RAShortcode {

    protected $slug = 'ra_form';
    
    function shortcode_handler($atts, $content = "") {
		$this->atts = shortcode_atts(
            array(
                'id'=>false,
                'form_style_css'=>'width:100%'
            ),$atts, 'ra_form');

        $data = array(
            "style"=>$this->atts["form_style_css"]
        );

        return $this->renderView('Form', $data);

    }
}