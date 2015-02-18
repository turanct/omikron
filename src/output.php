<?php

function displayTestResults($testResults)
{
    $output = '';

    $output .= 'topics: ' . $testResults('numberOfTopics') . "\n";
    $output .= 'features: ' . $testResults('numberOfFeatures') . "\n";
    $output .= 'assertions: ' . $testResults('numberOfAssertions') . "\n";
    $output .= "\n";

    $output .= implode(
        "\n",
        array_map(
            function($assertion) {
                return failedOutput($assertion[2], $assertion[1], $assertion[0]);
            },
            $testResults('failedAssertions')
        )
    );
    $output .= "\n";

    echo $output;
}

function failedOutput($topic, $feature, $assertion)
{
    return 'FAILED: '
           . $topic('getName')
           . ': ' . $feature('getName')
           . ' ' . $assertion('getDescription')
    ;
}
