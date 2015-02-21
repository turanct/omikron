<?php

return within('omikron',
    describe('"testResults"',
        it('counts its topics', function() {
            $topic1 = within('topic1', @_);
            $topic2 = within('topic2', @_);
            $topic3 = within('topic1', @_);

            // $topic3 is actually the same topic as $topic1. Most likely
            // 'topic1' is split over multiple files, so should count only once.

            $testResults1 = testResults([$topic1, $topic2, $topic3]);
            $testResults2 = testResults([$topic1, $topic2]);

            return
                $testResults1('numberOfTopics') == 2
                && $testResults2('numberOfTopics') == 2
            ;
        }),

        it('counts its features', function() {
            $topic1 = within('topic1', @1, @2, @3);
            $topic2 = within('topic2', @4, @5);

            $testResults1 = testResults([$topic1, $topic2]);
            $testResults2 = testResults([$topic1]);

            return
                $testResults1('numberOfFeatures') == 5
                && $testResults2('numberOfFeatures') == 3
            ;
        }),

        it('counts its assertions', function() {
            $topic1 = within('topic1',
                describe('foo', @1, @2, @3),
                describe('bar', @4, @5),
                describe('baz', @6)
            );
            $topic2 = within('topic2',
                describe('qux', @7, @8, @9)
            );

            $testResults1 = testResults([$topic1, $topic2]);
            $testResults2 = testResults([$topic1]);

            return
                $testResults1('numberOfAssertions') == 9
                && $testResults2('numberOfAssertions') == 6
            ;
        }),

        it('returns a list of failed assertions', function() {
            $topic1 = within('topic1',
                describe('foo',
                    it('fails1', function() { return false; }),
                    it('succeeds', function() { return true; }),
                    it('fails2', function() { return false; })
                ),
                describe('bar',
                    it('fails3', function() { return false; })
                ),
                describe('baz',
                    it('succeeds', function() { return true; })
                )
            );
            $topic2 = within('topic2',
                describe('qux',
                    it('succeeds', function() { return true; }),
                    it('fails4', function() { return false; }),
                    it('succeeds', function() { return true; })
                )
            );

            $testResults1 = testResults([$topic1, $topic2]);
            $testResults2 = testResults([$topic1]);

            $failedAssertions1 = $testResults1('failedAssertions');
            $failedAssertions2 = $testResults2('failedAssertions');

            return
                count($failedAssertions1) == 4
                && $failedAssertions1[0][0]('getDescription') == 'fails1'
                && $failedAssertions1[1][0]('getDescription') == 'fails2'
                && $failedAssertions1[2][0]('getDescription') == 'fails3'
                && $failedAssertions1[3][0]('getDescription') == 'fails4'

                && count($failedAssertions2) == 3
                && $failedAssertions2[0][0]('getDescription') == 'fails1'
                && $failedAssertions2[1][0]('getDescription') == 'fails2'
                && $failedAssertions2[2][0]('getDescription') == 'fails3'
            ;
        })
    )
);
