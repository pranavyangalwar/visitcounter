<?php

namespace Pranavsy\VisitCounter\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VisitCounter extends Component
{
    public string $slug;
    public int $visits = 0;

    public function mount(string $slug = '/'): void
    {
        $this->slug = $slug;

        $table = config('visit_counter.table', 'visit_counters');

        // Atomically increment the visits count for existing slug
        $updated = DB::table($table)
            ->where('slug', $this->slug)
            ->increment('visits');

        if (!$updated) {
            // If no rows updated, insert new record with visits = 1
            DB::table(config('visitcounter.table'))
                ->insert([
                    'slug' => $this->slug,
                    'visits' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            $this->visits = 1;
        } else {
            // Get the updated visits count
            $this->visits = DB::table(config('visitcounter.table'))
                ->where('slug', $this->slug)
                ->value('visits');
        }
    }

    public function render()
    {
        return view('visitcounter::counter');
    }
}
