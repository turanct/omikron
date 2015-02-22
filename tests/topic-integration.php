<?php

$sampleTopic = include(__DIR__.'/../examples/topic-calculus.php');

$expectedOutput = <<<OUTPUT
topics: 1
features: 2
assertions: 5

FAILED: calculus: addition adds two numbers
Expected 2 to be 3
FAILED: calculus: addition is difficult
Expected 6 to be 33
FAILED: calculus: subtraction looks strange
Expected 1 to be false.

OUTPUT;


return within("integration",
    describe("output from complete suite",
        it("renders everything we need to know", function() use($expectedOutput, $sampleTopic) {
            $renderedOutput = renderOutput(testResults([$sampleTopic]));
            return $renderedOutput === $expectedOutput;
        })
    )
);