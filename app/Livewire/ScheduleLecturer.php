<?php

namespace App\Livewire;

use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleLecturer extends Component
{
    use WithPagination;

    public function render()
    {
        $schedules = Schedule::query()
            ->with(['course', 'lecturerUser'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.schedule-lecturer', compact('schedules'));
    }
}

