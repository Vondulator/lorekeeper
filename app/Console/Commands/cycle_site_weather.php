<?php

namespace App\Console\Commands;

use App\Models\Weather\WeatherSeason;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Settings;

class cycle_site_weather extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cycle-site-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cycles the site\'s weather.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $currentseason = WeatherSeason::find(Settings::get('site_season'));
        $cycle = (int) Settings::get('site_weather_cycle');
        if (!$cycle) {
            $this->info('Not set to cycle weather currently. Adjust the settings if this is an error.');

            return self::SUCCESS;
        }
        if (!$currentseason) {
            $this->info('No valid season is set.');

            return self::SUCCESS;
        }

        $now = Carbon::now();
        $due = $cycle === 1 || ($cycle === 2 && $now->isMonday()) || ($cycle === 3 && $now->day === 1);
        if (!$due) {
            return self::SUCCESS;
        }
        if (!$currentseason->loot()->exists()) {
            $this->info('No valid weather found!');

            return self::SUCCESS;
        }

        $results = $currentseason->roll();
        $weather = isset($results['weathers']) ? collect($results['weathers'])->first() : null;
        if (!$weather || !isset($weather['asset'])) {
            $this->info('No valid weather found!');

            return self::SUCCESS;
        }

        DB::table('site_settings')->where('key', 'site_weather')->update(['value' => $weather['asset']->id]);
        $this->info('Weather adjusted successfully.');

        return self::SUCCESS;
    }
}
