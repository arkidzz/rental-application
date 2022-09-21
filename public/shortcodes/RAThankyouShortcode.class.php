<?php
class RAThankyouShortcode extends RAShortcode {

    protected $slug = 'ra_thankyou';

    function shortcode_handler($atts, $content = "") {

        $atts = shortcode_atts( array(
            'payment_success' => __('Your Payment is completed successfully.', RA_PLUGIN_TEXT_DOMAIN),
            'app_success' => __('You Have Successfully Completed the Application.', RA_PLUGIN_TEXT_DOMAIN)
        ), $atts );

        $data = $atts;

        return $this->renderView('Thankyou', $data);
    }
}