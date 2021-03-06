# clue/sse-react [![Build Status](https://travis-ci.org/clue/php-sse-react.svg?branch=master)](https://travis-ci.org/clue/php-sse-react)

Streaming, async HTML5 Server-Sent Events server (aka. SSE or EventSource), built on top of [React PHP](http://reactphp.org/).

> Note: This project is in early alpha stage! Feel free to report any issues you encounter.

## Quickstart example

See the [examples](examples).

## Install

The recommended way to install this library is [through composer](http://getcomposer.org). [New to composer?](http://getcomposer.org/doc/00-intro.md)

```JSON
{
    "require": {
        "clue/sse-react": "dev-master"
    }
}
```

## Tests

To run the test suite, you first need to clone this repo and then install all
dependencies [through Composer](http://getcomposer.org):

```bash
$ composer install
```

To run the test suite, go to the project root and run:

```bash
$ php vendor/bin/phpunit
```

## License

MIT
