<?php

/*
 * This file is part of the QBBR code.
 *
 * (c) Sokolov Innokenty <imqbbr@gmail.com>
 */

namespace QBBR;

class TorProxy
{
    const ANSWER_OK = '250 OK';

    /**
     * A cURL handle.
     *
     * @var resource
     */
    private $ch;

    public function __construct(string $torSocks5Proxy = 'socks5://127.0.0.1:9050')
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, \CURLOPT_PROXYTYPE, \CURLPROXY_SOCKS5);
        curl_setopt($this->ch, \CURLOPT_PROXY, $torSocks5Proxy);
        curl_setopt($this->ch, \CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, \CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, \CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, \CURLOPT_HEADER, false);
    }

    public function setUserAgent(string $userAgent)
    {
        curl_setopt($this->ch, \CURLOPT_USERAGENT, $userAgent);
    }

    public function useCookie(string $cookieFilePath = null)
    {
        $cookieFilePath = $cookieFilePath ?? tempnam(sys_get_temp_dir(), 'cookie_').'.txt';
        curl_setopt($this->ch, \CURLOPT_COOKIESESSION, true);
        curl_setopt($this->ch, \CURLOPT_COOKIEJAR, $cookieFilePath);
        curl_setopt($this->ch, \CURLOPT_COOKIEFILE, $cookieFilePath);
    }

    public function getCh()
    {
        return $this->ch;
    }

    /**
     * @throws TorProxyException
     */
    public function curl(string $url, array $postParameter = null): string
    {
        if (null !== $postParameter) {
            curl_setopt($this->ch, \CURLOPT_POSTFIELDS, http_build_query($postParameter));
        }

        curl_setopt($this->ch, \CURLOPT_URL, $url);

        $html = curl_exec($this->ch);

        if (false === $html) {
            throw new TorProxyException('curl_exec return false content.');
        }

        return $html;
    }

    /**
     * Signal NEWNYM.
     * Switch to clean circuits, so new application requests don't share any circuits with old ones.
     * Also clears the client-side DNS cache.
     * See signals: https://gitweb.torproject.org/torspec.git/tree/control-spec.txt#n444.
     *
     * @param string $ip   Control IP address
     * @param int    $port Control port
     *
     * @throws TorProxyException
     */
    public function changeTorCircuits(string $ip = '127.0.0.1', int $port = 9051)
    {
        $fp = fsockopen($ip, $port, $errno, $errstr, 10);

        if (!$fp) {
            throw new TorProxyException(sprintf('Error changing Tor proxy identity: [%d] %s', $errno, $errstr));
        }

        fwrite($fp, "AUTHENTICATE\n");
        $received = trim(fread($fp, 512));

        if (self::ANSWER_OK !== $received) {
            throw new TorProxyException($received);
        }

        fwrite($fp, "signal NEWNYM\n");
        $received = trim(fread($fp, 512));

        if (self::ANSWER_OK !== $received) {
            throw new TorProxyException($received);
        }

        fclose($fp);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
