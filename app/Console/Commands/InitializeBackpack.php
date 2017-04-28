<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitializeBackpack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom initialization of Backpack - running certain basic commands that are needed.';

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
     * @return mixed
     */
    public function handle()
    {
        $migrations = [
            'LangFile' => ['--path' => 'vendor/backpack/langfilemanager/src/database/migrations']
        ];

        $seeds = [
            'LangFile' => ["--class" => 'Backpack\LangFileManager\database\seeds\LanguageTableSeeder'],
            'Settings' => ["--class" => 'Backpack\Settings\database\seeds\SettingsTableSeeder']
        ];

        $this->info('Running Backpack migrations:');
        foreach ($migrations as $name => $parameters){
            $this->info('Migration: ' . $name);
            $this->call("migrate", $parameters);
        }
        $this->info("Backpack Migrations complete.\n");
        $this->info('Running Backpack seeds:');

        foreach ($seeds as $name => $parameters){
            $this->info('Seed: ' . $name);
            $this->call("db:seed", $parameters);
        }

        $this->info("Backpack Seeds complete.\n");

    }
}
