Omikron Test Framework
=============================

[![Travis CI](https://api.travis-ci.org/turanct/omikron.svg?branch=master)](https://travis-ci.org/turanct/omikron)

A simple, functional programming inspired, test framework.

![Ouroboros, the greek dragon eating its own tail](docs/omikron.png)

This project was started as a reaction to [this issue](https://github.com/mathiasverraes/lambdalicious/issues/22) and was initially [a gist](https://gist.github.com/turanct/129a6ed97ec3543ebafd). It's currently *not meant to be used in production*, but there's nobody stopping you if you want to.


Usage
-----------------------------

Installing it is easy, just require `turanct/omikron` as a development dependency in your `composer.json` file, and configure a `bin-dir`. The omikron executable will be available in your bin directory when you've run `composer install`.

```json
{
    "require-dev": {
        "turanct/omikron": "dev-master"
    },
    "config": {
        "bin-dir": "bin"
    }
}
```

Omikron has a concept of topics, topics are distinct parts of your code under test. These topics have different features, and to describe those features, there are assertions.

```php
<?php return

within("calculus",
    describe("addition",
        it("adds two numbers", function() { return
            expect(1 + 1, toBe(3)); // Will return false => failing test
        }),
        it("adds three numbers", function() { return
            expect(1 + 1 + 1, toBe(3));
        })
    ),
    describe("subtraction",
        it("subtracts two numbers", function() { return
            expect(3 - 2, toBe(1));
        })
    )
);
```

This is an example of a topic. It's in a file named `topics/topic-calculus.php`. Every topic file must have a name starting with `topic-`. You can split topics over multiple files if you want to. The topic `calculus` has two features, `addition` and `subtraction`, and both of those features have some assertions.

To run the tests for this topic, we'll just run `bin/omikron topics` (as `topics` is the directory with my topics). The output will be something like this:

```sh
$ bin/omikron topics
topics: 1
features: 2
assertions: 3

FAILED: calculus: addition adds two numbers
Expected 2 to be 3
```


Tests
-----------------------------

Omikron has unit tests, located in the `tests` directory. These tests are written using Omikron itself, so you can just run the Omikron executable on the tests dir!

```sh
$ bin/omikron tests
```


Contributing
-----------------------------

Feel free to fork and send pull requests!

