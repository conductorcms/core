<?php namespace Conductor\Core\Widgets\Video;

use Conductor\Core\Widget\Widget;

class Video extends Widget {

    public $name = 'Video';
    public $description = 'Embed a video!';

    public $options = [
        [
            'name' => 'Video Provider',
            'slug' => 'provider',
            'type' => 'select',
            'options' => [
                [
                    'key' => 'youtube',
                    'value' => 'YouTube'
                ],
                [
                    'key' => 'vimeo',
                    'value' => 'Vimeo'
                ]
            ]
        ],
        [
            'name' => 'Video ID',
            'slug' => 'code',
            'type' => 'input'
        ],
        [
            'name' => 'Width',
            'slug' => 'width',
            'type' => 'input',
        ],
        [
            'name' => 'Height',
            'slug' => 'height',
            'type' => 'input'
        ]
    ];

}