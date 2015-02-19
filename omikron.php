#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

exit(
    displayTestResults(
        testResults(
            getTopics(
                getDirectoriesFromArgv(
                    $argv
                )
            )
        )
    )
);
