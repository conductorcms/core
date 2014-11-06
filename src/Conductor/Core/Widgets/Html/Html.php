<?php namespace Conductor\Core\Widgets\Html;

use Conductor\Core\Widget\Widget;

class Html extends Widget {

	public $name = 'HTML';
	public $description = 'The HTML Widget';

	public $options = [
		[
            'name' => 'Body',
            'slug' => 'body',
            'type' => 'wysiwyg'
        ]
	];

}