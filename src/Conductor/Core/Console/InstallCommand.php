<?php namespace Conductor\Core\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'conductor:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Conductor.';

    /**
     * Create a new Console Instance
     *
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $email = $this->ask('Please enter the admin email:');
        $password = $this->ask('Please enter the admin password:');

        $this->call('migrate', ['--package' => 'conductor/core']);
        $this->call('migrate', ['--package' => 'cartalyst/sentinel']);
        $this->call('db:seed', ['--class' => 'Conductor\Core\Seeders\UserSeeder']);
        $this->call('conductor:create-admin', ['--email' => $email, '--password' => $password]);
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
