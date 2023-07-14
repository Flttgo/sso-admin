<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class GetTableColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tools:get-table-columns
                            {table : The table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取数据库字段';

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
        $table = $this->argument('table');

        $columns = DB::connection()->getSchemaBuilder()->getColumnListing($table);

        $columns = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);

        $this->newLine();

        $this->info('protected $fillable = [');

        foreach ($columns as $column) {
            $this->info("    '".$column."',");
        }

        $this->info('];');

        return 0;
    }
}
