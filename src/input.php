<?php

function getDirectoriesFromArgv(array $argv)
{
    array_shift($argv);

    return array_filter(
        array_map(
            function($dir) {
                if (in_array($dir, ['.', '/', '..'])) {
                    return false;
                }

                return realpath($dir) . '/';
            },
            $argv
        )
    );
}

function getTopics(array $dirs)
{
    if (!empty($dirs)) {
        $files = array_reduce(
            $dirs,
            function(array $files, $dir) {
                return array_merge($files, glob($dir . 'topic*.php'));
            },
            array()
        );
    } else {
        $files = glob('topic*.php');
    }

    return array_map(
        function($file) {
            return include($file);
        },
        $files
    );
}
