<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;

class UpdateRoomCapacity extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'rooms:update-capacity {capacity=5}';

    /**
     * The console command description.
     */
    protected $description = 'Update all room capacities to specified value';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $capacity = (int) $this->argument('capacity');
        
        $updated = Room::query()->update(['capacity' => $capacity]);
        
        $this->info("Updated {$updated} rooms capacity to {$capacity}");
        
        return 0;
    }
}