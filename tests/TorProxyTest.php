<?php

/*
 * This file is part of the QBBR code.
 *
 * (c) Sokolov Innokenty <imqbbr@gmail.com>
 */

namespace QBBR\Tests;

use PHPUnit\Framework\TestCase;
use QBBR\TorProxy;
use QBBR\TorProxyException;

final class TorProxyTest extends TestCase
{
    public function testCurl()
    {
        try {
            $torProxy = new TorProxy();
            $output = $torProxy->curl('http://ifconfig.me/ip');
        } catch (TorProxyException $exception) {
            $this->fail($exception->getMessage());
        }

        $this->assertTrue(false !== filter_var($output, FILTER_VALIDATE_IP));
    }

    public function testChangeTorCircuits()
    {
        try {
            $torProxy = new TorProxy();
            $torProxy->changeTorCircuits();
        } catch (TorProxyException $exception) {
            $this->fail($exception->getMessage());
        }

        $this->assertTrue(true);
    }
}
