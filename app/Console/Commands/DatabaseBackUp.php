<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d-H-i-s') . ".sql";
        $command = "mysqldump --no-defaults  --column-statistics=0 -uroot -pDb2@dm1n2022 --databases --add-drop-database Mixins  > " . storage_path() . "/app/backup/" . $filename;
        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
