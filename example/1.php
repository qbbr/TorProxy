<?php

/*
 * This file is part of the QBBR code.
 *
 * (c) Sokolov Innokenty <imqbbr@gmail.com>
 */

require __DIR__.'/../vendor/autoload.php';

$torProxy = new \QBBR\TorProxy();

//curl_setopt($torProxy->getCh(), CURLOPT_SSL_VERIFYPEER, true);
//$torProxy->useCookie();
//$torProxy->changeTorCircuits();
//$torProxy->setUserAgent('Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
// OR https://github.com/fzaninotto/Faker
//$torProxy->setUserAgent(\Faker\Factory::create()->chrome);

$output = $torProxy->curl('http://ifconfig.me/ip'); // GET
var_dump($output);

//$output = $torProxy->curl('https://rutracker.org/', [ // POST
    //'post_param_1' => 'val1',
//]);
