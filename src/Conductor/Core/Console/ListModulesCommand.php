<?php namespace Conductor\Core\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Conductor\Core\Module\ModuleRepository;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ListModulesCommand extends Command {

    protected $module;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List registered modules.';

    /**
     * Create a new Console Instance
     *
     * @param ModuleRepository $module
     */
    public function __construct(ModuleRepository $module)
    {
        $this->module = $module;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $modules = $this->module->getAll();

        $this->info('Modules found: ' . $modules->count());

        foreach ($modules as $module)
        {
            $installed = ($module->installed ? 'Yes' : 'No');
            $this->info($module->name . ' ' . $installed);
        }

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
