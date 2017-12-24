<?php
namespace WordPress\Plugin\EveOnlineIntelTool\Libs\GuzzleHttp\Psr7;

use WordPress\Plugin\EveOnlineIntelTool\Libs\Psr\Http\Message\StreamInterface;

/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream implements StreamInterface
{
    use StreamDecoratorTrait;

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }

    public function isSeekable()
    {
        return false;
    }
}
