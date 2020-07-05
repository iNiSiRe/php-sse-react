<?php

require __DIR__ . '/../vendor/autoload.php';

use Clue\React\Sse\BufferedChannel;

$loop = React\EventLoop\Factory::create();

$channel = new BufferedChannel();

$http = new React\Http\Server(function (\Psr\Http\Message\RequestInterface $request) use ($channel, $loop) {
    if ($request->getUri()->getPath() === '/') {
        return new \React\Http\Response(
            200,
            array('Content-Type' => 'text/html'),
            file_get_contents(__DIR__ . '/00-eventsource.html')
        );
    }

    if ($request->getUri()->getPath() !== '/demo') {
        return new \React\Http\Response(
            404,
            array(),
            'Not found'
        );
    }

    echo 'connected' . PHP_EOL;

    $id = $request->getHeaderLine('Last-Event-ID');

    $stream = new \React\Stream\ThroughStream();

    $stream->on('close', function () use ($stream, $channel) {
        echo 'disconnected' . PHP_EOL;
        $channel->disconnect($stream);
    });

    $loop->nextTick(function () use ($channel, $stream, $id) {
        $channel->connect($stream, $id);
    });

    return new \React\Http\Response(
        200,
        array('Content-Type' => 'text/event-stream'),
        $stream
    );
});

$loop->addPeriodicTimer(2.0, function() use ($channel) {
    $channel->writeMessage('ticking ' . mt_rand(1, 5) . '...');
});

$uri = isset($argv[1]) ? $argv[1] : '0.0.0.0:8080';
$socket = new React\Socket\Server($uri, $loop);
$http->listen($socket);

echo 'Server now listening on ' . $socket->getAddress() . ' (address is first parameter)' . PHP_EOL;
echo 'This will send a message every 2 seconds' . PHP_EOL;

$loop->run();
