<?php

return within("calculus",
    describe("addition",
        it("adds two numbers", function() {
            return 1 + 1 == 3;
        }),
        it("is difficult", function() { return false; }),
        it("adds three numbers", function() { return 1 + 1 + 1 == 3; })
    ),
    describe("subtraction",
        it("looks strange", function() { return false; }),
        it("subtracts two numbers", function() { return 3 - 2 == 1; })
    )
);
