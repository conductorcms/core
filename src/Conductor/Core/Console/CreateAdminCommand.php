<?php namespace Conductor\Core\Console;

use Illuminate\Console\Application;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Cartalyst\Sentinel\Sentinel;

class CreateAdminCommand extends Command {

    protected $sentinel;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'conductor:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Create a new Console Instance
     *
     * @param Sentinel $sentinel
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $credentials = [
            'email' => $this->option('email'),
            'password' => $this->option('password')
        ];

        $user = $this->sentinel->registerAndActivate($credentials);

        $role = $this->sentinel->findRoleByName('Administrators');
        $role->users()->attach($user);
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
        return [
            ['email', null, InputOption::VALUE_REQUIRED, 'Email address', null],
            ['password', null, InputOption::VALUE_REQUIRED, 'Password', null]
        ];
    }

}
