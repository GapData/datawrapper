<?php

/*
 * parses the config and populates some defaults
 */

function parse_vis_options(&$vis) {
    $option_parts = ['options'];
    if (!empty($vis['annotate_options'])) {
        $option_parts[] = 'annotate_options';
    }
    // clean vis options
    foreach ($option_parts as $options_key) {
        foreach ($vis[$options_key] as $key => $g_option) {
            if ($g_option['type'] != 'group') {
                $options = [$g_option];
            } else {
                $options = $g_option['options'];
            }
            foreach ($options as $sub_key => $option) {
                if (!empty($option['options'])) {
                    $opts = $option['options'];
                    if (array_keys($opts) !== range(0, count($opts) - 1)) {
                        // associative array, convert to sequential
                        $new_opts = [];
                        foreach ($opts as $val => $label) {
                            $new_opts[] = ['value' => $val, 'label' => $label];
                        }
                        if ($g_option['type'] != 'group') {
                            $vis[$options_key][$key]['options'] = $new_opts;
                        } else {
                            $vis[$options_key][$key]['options'][$sub_key]['options'] = $new_opts;
                        }
                    } 
                }
            }
        }
    }
}
