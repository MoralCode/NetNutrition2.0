<?php

namespace App\Console\Commands;

use App\DiningCenter;
use File;
use Illuminate\Console\Command;

class WebScrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:netnutrition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape the net nutrition web site';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $webScraperData = json_decode(File::get('app/Console/PythonWebScraper/data.json'), true, 2048);

        foreach ($webScraperData as $diningCenter => $menus) {
            $diningCenter = DiningCenter::whereName($diningCenter)->firstOrCreate([
                'name' => $diningCenter,
                'latitude' => 0,
                'longitude' => 0,
            ]);
        }

        dd();
    }
}