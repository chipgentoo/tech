<?php

class Utils {

    /**
     * @param string $page
     * @return string
     */
    public static function getPath($page) {
        $doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
        $script_name = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
        $project = $doc_root . $script_name;
        $path = dirname($project) . '/section/' . $page . '/';
        return $path;
    }

}
