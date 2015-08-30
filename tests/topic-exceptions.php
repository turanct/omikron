<?php

function bad()
{
    throw new Exception('Something');
}

$sampleTopic = within("foo",
    describe("bar",
        it("throws an exception", function() { return
            expect(bad(), toBe('good'));
        })
    )
);

$expectedOutput = <<<OUTPUT
topics: 1
features: 1
assertions: 1

FAILED: foo: bar throws an exception

Exception: Something in /vagrant/tests/topic-exceptions.php on line 5

Call stack:
#0 /vagrant/tests/topic-exceptions.php(11): bad()
#1 /vagrant/src/omikron.php(51): {closure}()
#2 /vagrant/tests/topic-exceptions.php(12): it('throws an excep...', Object(Closure))
#3 /vagrant/src/input.php(37): include('/vagrant/tests/...')
#4 [internal function]: {closure}('/vagrant/tests/...')
#5 /vagrant/src/input.php(40): array_map(Object(Closure), Array)
#6 /vagrant/bin/omikron(30): getTopics(Array)
#7 {main}

OUTPUT;
$expectedOutput = str_replace('/vagrant', dirname(__DIR__), $expectedOutput);

return within("omikron",
    describe("assertion",
        it("catches exceptions in callable", function() use ($sampleTopic, $expectedOutput) {
            try {
                $renderedOutput = renderOutput(testResults([$sampleTopic]));
            } catch (Exception $e) {
                $renderedOutput = '';
            }

            return expect($renderedOutput, toBe($expectedOutput));
        })
    )
);
