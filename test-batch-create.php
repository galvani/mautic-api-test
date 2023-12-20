#!/bin/php
<?php

include __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client;
use Mautic\Auth\ApiAuth;

session_start();

$settings = [
    'baseUrl'      => 'http://localhost:8084',       // Base URL of the Mautic instance
    'version'      => 'OAuth2', // Version of the OAuth can be OAuth2 or OAuth1a. OAuth2 is the default value.
    'clientKey'    => '2_3pzekjxdhtuswwkcoow4wo48os04wow8sgo4k4og84ggcwo80k',       // Client/Consumer key from Mautic
    'clientSecret' => '5d6z47ps7xssgg0w08csokskskgs4oswc8s408w8gkgko04kk4',       // Client/Consumer secret key from Mautic
    'accessToken'  => 'ZjQ2MTJhNzJjZmU1ZWE5NmZkOTA4MjQ2Mzg5MTZlNjg3ZWRmMTI0YjFhNWE3OTJmZjkyMTA5ZmZkNmViNDE1Nw',
];


// Initiate the auth object specifying to use BasicAuth
$initAuth = new ApiAuth();
$auth     = $initAuth->newAuth($settings, 'OAuth');

// Initiate an HTTP Client
$httpClient = new Client(['timeout' => 10]);

$logger = new \Monolog\Logger('mautic-api');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__.'/app.log', 'debug'));

$api        = new \Mautic\MauticApi();
$contactApi = $api->newApi('contacts', $auth, $settings['baseUrl'].'/api');
$contactApi->setLogger($logger);
echo "Creating contact...\n";

$batch = [
    [ 
        "email" => "jean.c03t@gmail.com", 
        "customObjects" => [
            "data" => [
                [
                    "id"   => 1,
                    "data" => [
                        ["name"       => "Hello From API2",
                        "attributes" => [
                            "updated" => "2018-10-10T14:00:00+02:00"
                        ]

                        ]
                    ]
                ]
            ]
        ]
    ]
];

$response = $contactApi->createBatch($batch, ['includeCustomObjects' => true],);
print_r($response);
die();



$response = $contactApi->createBatch(
    [
        [
            'overwriteWithBlank' => true,
            'firstname'     => 'John',
            'lastname'      => 'Doe',
            'email'         => 'ggg.lan@ddd.cz',
            "customObjects" => [
                "data" => [
                    [
                        "id"   => 1,
                        "data" => [
                            ["name"       => "Hello From API2",
                             "attributes" => [
                                 "updated" => "2018-10-10T14:00:00+02:00"
                             ]

                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
);

var_dump($response);
