<?php

$sampleTopic = include(__DIR__.'/../examples/topic-calculus.php');

$expectedOutput = <<<OUTPUT
topics: 1
features: 2
assertions: 5

FAILED: calculus: addition adds two numbers
Expected values to be equal, instead got:
--- Actual
+++ Expected
@@ @@
-2
+3

FAILED: calculus: addition is difficult
Expected values to be equal, instead got:
--- Actual
+++ Expected
@@ @@
-6
+33

FAILED: calculus: subtraction looks strange
Expected value to be false

OUTPUT;


return within("integration",
    describe("output from complete suite",
        it("renders everything we need to know", function() use($expectedOutput, $sampleTopic) {
            $renderedOutput = renderOutput(testResults([$sampleTopic]));
            return $renderedOutput === $expectedOutput;
        })
    )
);