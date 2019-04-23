<?php
@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('denisyilmaz/oembed', [
    'fields' => [
        'oembed' => [
            'props' => [
                'message' => '<k-oembed-field></k-oembed-field>'
            ]
        ]
    ]
]);
