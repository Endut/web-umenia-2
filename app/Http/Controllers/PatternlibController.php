<?php

namespace App\Http\Controllers;

class PatternlibController extends Controller
{
    const COMPONENT_BASE_PATH = '../resources/views/components/';

    public function getIndex()
    {            
        // get json file names
        $file_names = array();
        $handle = opendir(self::COMPONENT_BASE_PATH);
        while (false !== ($file_name = readdir($handle))) {
            if (ends_with($file_name, '.json')) {
                $file_names[] = $file_name;
            }
        }
        sort($file_names);

        // add base path
        $file_paths = array();
        foreach ($file_names as $index => $file_name) {
            $file_paths[$index] = self::COMPONENT_BASE_PATH.$file_name;
        }

        // decode json
        $components_json = array();
        foreach ($file_paths as $file_path) {
            $file_str = file_get_contents($file_path);
            $file_json = json_decode($file_str, true);
            $components_json[] = $file_json;
        }

        // add attributes
        foreach ($components_json as $index => $component) {
            $components_json[$index]['include_path'] = 'components.'.substr($file_names[$index], 0, -5);
            $components_json[$index]['source_code'] = file_get_contents(substr($file_paths[$index], 0, -5).'.blade.php');
        }

        return view('patternlib', [
            'components' => $components_json
        ]);
    }
}
