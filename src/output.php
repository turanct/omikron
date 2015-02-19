<?php

function displayTestResults($testResults)
{
    $output = '';

    $output .= 'topics: ' . $testResults('numberOfTopics') . "\n";
    $output .= 'features: ' . $testResults('numberOfFeatures') . "\n";
    $output .= 'assertions: ' . $testResults('numberOfAssertions') . "\n";
    $output .= "\n";

    $failedAssertions = $testResults('failedAssertions');
    $output .= implode(
        "\n",
        array_map(
            function($assertion) {
                return failedOutput($assertion[2], $assertion[1], $assertion[0]);
            },
            $failedAssertions
        )
    );
    $output .= "\n";

    echo $output;

    return (empty($failedAssertions)) ? 0 : 1;
}

function failedOutput($topic, $feature, $assertion)
{
    return 'FAILED: '
           . $topic('getName')
           . ': ' . $feature('getName')
           . ' ' . $assertion('getDescription')
    ;
}
