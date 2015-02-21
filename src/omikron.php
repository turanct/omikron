<?php

function within($topic, ...$features)
{
    return (object)[
        'name' => $topic,
        'failedAssertions' =>
            array_reduce(
                $features,
                function ($failedAssertions, $feature) {
                    return array_merge(
                        $failedAssertions,
                        array_map(
                            function ($assertion) use ($feature) {
                                return array($assertion, $feature);
                            },
                            $feature->failedAssertions
                        )
                    );
                },
                array()
            ),
        'numberOfFeatures' => count($features),
        'numberOfAssertions' =>
            array_reduce(
                $features,
                function ($number, $feature) {
                    return $number + $feature->numberOfAssertions;
                },
                0
            ),
    ];
}

function describe($feature, ...$assertions)
{
    return (object)[
        'name' => $feature,
        'failedAssertions' =>
            array_filter(
                $assertions,
                function ($assertion) { return !$assertion->assert; }
            ),
        'numberOfAssertions' => count($assertions)
    ];
}

function it($doesThis, callable $correctly)
{
    return (object)[
        'assert' => (bool)$correctly(),
        'description' => (string)$doesThis
    ];
}

function testResults(array $topics)
{
    return (object)[
        'numberOfTopics' =>
           count(array_unique(array_map(
               function ($topic) { return $topic->name; },
               $topics
            ))),
        'numberOfFeatures' =>
            array_reduce(
                $topics,
                function ($number, $topic) {
                    return $number + $topic->numberOfFeatures;
                },
                0
            ),
        'numberOfAssertions' =>
            array_reduce(
                $topics,
                function ($number, $topic) {
                    return $number + $topic->numberOfAssertions;
                },
                0
            ),
        'failedAssertions' =>
            array_reduce(
                $topics,
                function ($failedAssertions, $topic) {
                    $assertions = $topic->failedAssertions;

                    $assertions = array_map(
                        function ($assertion) use ($topic) {
                            $assertion[] = $topic;
                            return $assertion;
                        },
                        $assertions
                    );

                    return array_merge($failedAssertions, $assertions);
                },
                array()
            ),
        ];
}
