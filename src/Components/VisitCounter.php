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

        // Increment atomically
        $this->visits = DB::table(config('visitcounter.table'))
            ->updateOrInsert(
                ['slug' => $this->slug],
                ['visits' => DB::raw('visits + 1')]
            )
            ->where('slug', $this->slug)
            ->value('visits');
    }

    public function render()
    {
        return view('visitcounter::counter');
    }
}
