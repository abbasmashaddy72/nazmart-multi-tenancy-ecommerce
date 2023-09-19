<?php

namespace Modules\Anabo\Http\Pagebuilder\Addons;

use App\Helpers\SanitizeInput;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;
use function __;

class FullScreenImageSlider extends PageBuilderBase
{
    // This function return the image name of the addon
    public function preview_image()
    {
        return 'full_screen_image_slider.png';
    }

    // This function points the location of the image, It accept only module name
    public function setAssetsFilePath()
    {
        return externalAddonImagepath('Anabo');
    }

    // This function contains addon settings while using the addon in the page builder
    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();

        $output .= Repeater::get([
            'multi_lang' => true,
            'settings' => $widget_saved_values,
            'id' => 'fullscreen_image_slider_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_title',
                    'label' => __('Title')
                ],
                [
                    'type' => RepeaterField::TEXTAREA,
                    'name' => 'repeater_description',
                    'label' => __('Description')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_text',
                    'label' => __('Button Text')
                ],
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_button_url',
                    'label' => __('Button URL')
                ],
                [
                    'type' => RepeaterField::IMAGE,
                    'name' => 'repeater_right_image',
                    'label' => __('Right Image'),
                    'dimensions'=> __('(636*788)')
                ],

            ]
        ]);

        // add padding option
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    // This function will render the addon on frontend, you can get the inputed values passed from the admin_render function
    public function frontend_render()
    {
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));
        $bg_image = SanitizeInput::esc_html($this->setting_item('bg_image'));
        $repeater_data = $this->setting_item('fullscreen_image_slider_repeater') ?? [];

        $data = [
            'padding_top'=> $padding_top,
            'padding_bottom'=> $padding_bottom,
            'bg_image'=> $bg_image,
            'repeater_data'=> $repeater_data,
        ];

        // self::renderView function will render the view file, this function will take three parameter, your view file name, passed array, module name
        return self::renderView('fullscreen-image-slider', $data, 'Anabo');
    }

    // Only tenant will get the addon if you use this function, otherwise landlord will also able to use the same addon
//    public function enable(): bool
//    {
//        return (bool)!is_null(tenant());
//    }

    // This function sets the addon name
    public function addon_title()
    {
        return __("Full Screen Image Slider");
    }
}
