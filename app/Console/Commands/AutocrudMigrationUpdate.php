<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class AutocrudMigrationUpdate extends Command
{
    protected $signature = 'autocrud:migration-update';
    protected $description = 'Implement the migration modifiers';
    public $command_run_count = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $list_modules = config('modules.load');
        $list_modules = array_merge(['App\Core\Providers\CoreServiceProvider'], $list_modules);

        $migration_modifiers = array_map(function ($item) {
            $split = explode('\\', $item);
            $last = $split[count($split) - 1];
            $second_last = $split[count($split) - 2];
            return str_replace($second_last . '\\' . $last, 'Extenders\\MigrationModifier', $item);
        }, $list_modules);

        $total_run = 0;
        foreach ($migration_modifiers as $mclass) {
            if (class_exists($mclass)) {
                //run database migration modifier
                $dbmodifier = app($mclass);
                $dbmodifier->handle();
                $run_count = $dbmodifier->getCommandRunCount(); //get run count
                $infos = $dbmodifier->getInfo(); //additional info for logging
                if (!empty($infos)) {
                    Log::info($mclass . ' update migration report : ' . json_encode($infos));
                }
                if ($run_count > 0) {
                    $total_run += $run_count;
                    $this->info($mclass . ' : ' . $run_count . ' database change request has been made.');
                } else {
                    $this->info($mclass . ' : no database change request applied');
                }
            } else {
                //cuma log error krn classnya gaada aja kok
                $this->error($mclass . ' is skipped because the class is not exists');
            }
        }

        if ($total_run == 0) {
            $this->info('Hooray! Your database structured is already in the most updated version');
        }
    }

}
