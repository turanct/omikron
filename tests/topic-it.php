<?php

return within('omikron',
    describe('"it"',
        it('has a description', function() {
            $it = it('description', function() { return true; });

            return $it('getDescription') == 'description';
        }),

        it('returns true when the assertion succeeded', function() {
            $it = it(@_, function() { return 1 + 1 == 2; });

            return $it('assert') == true;
        }),

        it('returns false when the assertion failed', function() {
            $it = it(@_, function() { return 1 + 1 == 3; });

            return $it('assert') == false;
        })
    )
);
