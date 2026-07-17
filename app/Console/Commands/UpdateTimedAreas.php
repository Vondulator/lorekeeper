<?php

namespace App\Console\Commands;

use App\Models\Encounter\EncounterArea;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateTimedAreas extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-timed-areas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hides timed encounter areas, or sets active if ready.';

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
        // activate or deactivate the areas
        $now = Carbon::now();
        EncounterArea::where('is_active', 1)->whereNotNull('end_at')->where('end_at', '<=', $now)->update(['is_active' => 0]);
        EncounterArea::where('is_active', 0)
            ->where(function ($query) use ($now) {
                $query->whereNull('start_at')->orWhere('start_at', '<=', $now);
            })->where(function ($query) use ($now) {
                $query->whereNull('end_at')->orWhere('end_at', '>', $now);
            })->update(['is_active' => 1]);
    }
}
