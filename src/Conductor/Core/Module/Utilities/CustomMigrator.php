<?php namespace Conductor\Core\Module\Utilities;

use Illuminate\Database\Migrations\Migrator;
use DB;

class CustomMigrator extends Migrator {

    public function rollBackPath($path)
    {
        $migrations = $this->getMigrationFiles($path);

        foreach ($migrations as $file)
        {
            DB::table('migrations')->where('migration', $file)->delete();
            $migration = $this->resolve($file);
            $migration->down();
        }

    }

}