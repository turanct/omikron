<?php

function displayTestResults($testResults)
{
    echo renderOutput($testResults);
    return (count($testResults->failedAssertions)) ? 1 : 0;
}

function renderOutput($testResults)
{
    $output = '';

    $output .= 'topics: ' . $testResults->numberOfTopics . "\n";
    $output .= 'features: ' . $testResults->numberOfFeatures . "\n";
    $output .= 'assertions: ' . $testResults->numberOfAssertions . "\n";
    $output .= "\n";

    $output .= implode(
        "\n",
        array_map(
            function ($assertion) {
                return failedOutput($assertion[2], $assertion[1],
                    $assertion[0]);
            },
            $testResults->failedAssertions
        )
    );
    $output .= "\n";

    return $output;
}

function failedOutput($topic, $feature, $assertion)
{
    return 'FAILED: '
           . $topic->name
           . ': ' . $feature->name
           . ' ' . $assertion->description
    ;
}
