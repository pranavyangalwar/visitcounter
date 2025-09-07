<?php

namespace Pranavsy\VisitCounter\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VisitCounter extends Component
{
    public string $slug;
    public int $visits = 0;

    public function mount(string $slug = '/'): void
    {
        $this->slug = filter_var($slug, FILTER_SANITIZE_STRING);

        $table = config('visit_counter.table', 'visit_counters');

        try {
            // Attempt atomic increment for existing slug
            $updated = DB::table($table)
                ->where('slug', $this->slug)
                ->increment('visits');

            if (!$updated) {
                // Insert new row if slug not found
                DB::table($table)->insert([
                    'slug' => $this->slug,
                    'visits' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->visits = 1;
            } else {
                // Fetch updated visits count
                $this->visits = DB::table($table)
                    ->where('slug', $this->slug)
                    ->value('visits');
            }
        } catch (\Exception $e) {
            Log::error('VisitCounter DB error: ' . $e->getMessage(), ['slug' => $this->slug]);

            // Set a fallback visits count or keep it 0
            $this->visits = 0;

            // Optional: provide feedback or silent failure depending on your UX strategy
        }
    }

    public function render()
    {
        return view('visitcounter::counter');
    }
}
