<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class NawasenaSetup extends Command
{
    private static $template = '
<fg=blue>
███╗   ██╗ █████╗ ██╗    ██╗ █████╗ ███████╗███████╗███╗   ██╗ █████╗ 
████╗  ██║██╔══██╗██║    ██║██╔══██╗██╔════╝██╔════╝████╗  ██║██╔══██╗
██╔██╗ ██║███████║██║ █╗ ██║███████║███████╗█████╗  ██╔██╗ ██║███████║
██║╚██╗██║██╔══██║██║███╗██║██╔══██║╚════██║██╔══╝  ██║╚██╗██║██╔══██║
██║ ╚████║██║  ██║╚███╔███╔╝██║  ██║███████║███████╗██║ ╚████║██║  ██║
╚═╝  ╚═══╝╚═╝  ╚═╝ ╚══╝╚══╝ ╚═╝  ╚═╝╚══════╝╚══════╝╚═╝  ╚═══╝╚═╝  ╚═╝                                                                                                                                                                                                     
</>
Congratulations! You successfully set up your <fg=green>nawasena</>!
<fg=cyan>Documentation</>: (Coming Soon)
<fg=cyan>Contribute</>: https://github.com/wreative/nawasena/graphs/contributors
<fg=cyan>Give a star</>: https://github.com/wreative/nawasena
Made with <fg=green>love</> by the community. Be a part of it!
';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nawasena:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup nawasena function';

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
        // $this->env();
        // $this->connection();
        // $this->key();
        // $this->clear();
        // $this->migrate();
        // $this->passport();
        $this->warn('This feature will come when other libraries support PHP 8, please configure it manually!');
        $this->line(self::$template);
    }

    function key()
    {
        Artisan::call("key:generate");
        $this->info('Application Key Set Successfully.');
    }

    function migrate()
    {
        Artisan::call("migrate:refresh --seed");
        $this->info('Importing Database Successful.');
    }

    function clear()
    {
        Artisan::call("optimize:clear");
        $this->info('Cache Cleared Successfully.');
    }

    function env()
    {
        // Copy .env file
        if (!file_exists(base_path('.env'))) {
            copy(base_path('.env.example'), base_path('.env'));
            $this->info('Environment File Created Successful.');
        }
    }

    function passport()
    {
        Artisan::call("passport:install");
    }

    function connection()
    {
        $this->info('Database Setup');
        foreach (['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME'] as $key) {
            $config[$key] = $this->ask('- ' . $key . ' (' . env($key) . ')');
            Artisan::call("env:set $key $config[$key]");
        }
        $config['DB_PASSWORD'] = $this->secret('- DB_PASSWORD (' . env($key) . ')');
        Artisan::call("env:set DB_PASSWORD $config[DB_PASSWORD]");
        $this->info('Set Database Connection Successful.');
    }
}