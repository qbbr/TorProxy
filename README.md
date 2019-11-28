# TorProxy

Simple PHP cURL wrapper for Tor network.

[![Latest Stable Version](https://poser.pugx.org/qbbr/tor-proxy/v/stable)](https://packagist.org/packages/qbbr/tor-proxy)
[![Total Downloads](https://poser.pugx.org/qbbr/tor-proxy/downloads)](https://packagist.org/packages/qbbr/tor-proxy)
[![License](https://poser.pugx.org/qbbr/tor-proxy/license)](https://packagist.org/packages/qbbr/tor-proxy)

## requirements

 * php-curl

## install

### tor

```bash
apt install tor
# [optional] if u using `$torProxy->changeTorCircuits()` u *must* access to tor control
sed -e 's/#ControlPort 9051/ControlPort 9051/' -i /etc/tor/torrc
sed -e 's/#CookieAuthentication 1/CookieAuthentication 0/' -i /etc/tor/torrc
systemctl restart tor
```

### lib

```bash
composer req qbbr/tor-proxy
```

## tests

```bash
./vendor/bin/phpunit
```

tested on: Debian 9 amd64, Ubuntu 16.10 amd64, Win7 Ultimate x32

## example

```bash
php example/1.php
```
