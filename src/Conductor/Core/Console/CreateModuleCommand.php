<?php namespace Conductor\Core\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Conductor\Core\Module\Utilities\Fabricator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Config;

class CreateModuleCommand extends Command {

    /**
     * Fabricator class to fabricate
     *
     * @var Fabricator
     */
    protected $fabricator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Create a new Console Instance
     *
     * @param Fabricator $fabricator
     */
    public function __construct(Fabricator $fabricator)
    {
        $this->fabricator = $fabricator;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        //get module info from user
        $info = $this->getModuleInfo();

        //make package
        $this->call('workbench', ['package' => $info['name'], '--resources' => true]);

        //generate skeleton files
        $this->fabricator->setModuleInfo($info);
        $this->fabricator->fabricate();

        //refresh module list, publish assets, etc
        $this->refreshModules($info['name']);
    }

    /**
     * Get info for new module from user
     *
     * @return array
     */
    private function getModuleInfo()
    {
        //get module info
        $questions = $this->getModuleQuestions();
        $module = $this->askQuestionsFromArray($questions);

        //transform some properties
        $module['backend'] = $this->stringToBoolean($module['backend']);
        $module['frontend'] = $this->stringToBoolean($module['frontend']);

        //get assets
        $module['assets'] = $this->getModuleAssets();

        //get author
        $module['author'] = [
            'name' => Config::get('workbench.name'),
            'email' => Config::get('workbench.email')
        ];

        return $module;
    }

    /**
     * Get questions array
     *
     * @return array
     */
    private function getModuleQuestions()
    {
        return [
            'name' => 'What is the package name? (E.g. conductor/pages)',
            'display_name' => 'What is the module\'s name?',
            'version' => 'What is the module\'s version?',
            'description' => 'What is the module\'s description?',
            'backend' => 'Will this module have a back-end component? (Y or N)',
            'frontend' => 'Will this module have a front-end component? (Y or N)',
        ];
    }

    /**
     * Ask questions from array
     *
     * @param array $questions
     * @return array
     */
    private function askQuestionsFromArray(array $questions)
    {
        $answers = [];
        foreach ($questions as $key => $question)
        {
            $answers[$key] = $this->ask($question);
        }
        return $answers;
    }

    /**
     * Converts string to true/false
     *
     * @param $string
     * @return bool
     */
    private function stringToBoolean($string)
    {
        return ($string == 'Y' || $string == 'y' ? true : false);
    }

    /**
     * Return module assets array for module.json
     *
     * @return array
     */
    private function getModuleAssets()
    {
        return [
            'admin' => [
                'js' => [
                    'resources/admin/js/**/*.js'
                ],
                'sass' => [
                    'resources/admin/sass/**/*.scss'
                ],
                'views' => [
                    'resources/admin/views/**/*.html'
                ],
                'dependencies' => [
                    'css' => [

                    ],
                    'js' => [

                    ]
                ]
            ],
            'frontend' => [
                'js' => [

                ],
                'sass' => [

                ],
                'dendencies' => [
                    'css' => [

                    ],
                    'js' => [

                    ]
                ]
            ]
        ];
    }

    /**
     * Run commands to integrate new module
     *
     * @param $newModule
     */
    public function refreshModules($newModule)
    {
        //$this->call('publish:assets', ['--bench' => $newModule]);
        $this->call('dump-autoload');

        $this->call('module:scan');
        $this->call('module:compile-assets');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
