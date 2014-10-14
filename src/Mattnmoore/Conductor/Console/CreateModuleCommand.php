<?php namespace Mattnmoore\Conductor\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;
use App, Config;

class CreateModuleCommand extends Command
{

    protected $files;
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
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $module = $this->getModuleInfo();

        //make package
        $this->call('workbench', ['package' => $module['name'], '--resources' => true]);

        //generate skeleton files
        $this->fabricator->fabricate($module);

        //include new module files
        require $providerPath . 'ModuleProvider.php';
        require $providerPath . '.php';

        $provider = $data['namespace'] . '\\' . $data['className'] . '\\' . $data['className'] . 'ModuleProvider';

        $config = Config::get('conductor::modules');
        $config[] = $provider;
        Config::set('conductor::modules', $config);

        $provider = new $provider(App::make('app'));
        $provider->registerModule();

        $this->call('publish:assets', ['--bench' => $data['package_name']]);

        $this->call('module:scan');
        $this->call('module:compile-assets');
    }

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

        return $module;
    }

    private function getModuleQuestions()
    {
        return [
            'name' => 'What is the package name? (E.g. mattnmoore/conductor)',
            'display_name' => 'What is the module\'s name?',
            'version' => 'What is the module\'s version?',
            'description' => 'What is the module\'s description?',
            'backend' => 'Will this module have a back-end component? (Y or N)',
            'frontend' => 'Will this module have a front-end component? (Y or N)',
        ];
    }

    private function askQuestionsFromArray(array $questions)
    {
        $answers = [];
        foreach ($questions as $key => $question) {
            $answers[$key] = $this->ask($question);
        }
        return $answers;
    }

    private function stringToBoolean($string)
    {
        return ($string == 'Y' || $string == 'y' ? true : false);
    }

    private function getModuleAssets()
    {
        return [
            'js' => [
                'resources/js/**/*.js'
            ],
            'sass' => [
                'resources/sass/**/*.scss'
            ]
        ];
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
