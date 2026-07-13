<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class DosenRecap extends Component
{
    use WithPagination;

    public string $date = '';
    public int $scheduleId = 0;
    public string $statusFilter = '';

    public function mount(): void
    {
        $this->date = Carbon::today()->toDateString();
    }

    public function schedulesForLecturer(): LengthAwarePaginator
    {
        // jadwal dosen yang sesuai role dosen (pemilik schedule)
        $today = Carbon::parse($this->date);
        $dayMap = [
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            0 => 'sun',
        ];

        $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';

        return Schedule::query()
            ->where('user_id', (int) auth()->id())
            ->where('day', $dayKey)
            ->with(['course', 'lecturerUser'])
            ->orderBy('start_time')
            ->paginate(20);
    }

    public function render()
    {
        $date = Carbon::parse($this->date)->toDateString();

        // ambil jadwal yang dimiliki dosen pada hari tersebut
        $schedules = Schedule::query()
            ->where('user_id', (int) auth()->id())
            ->where(function ($q) use ($date) {
                $today = Carbon::parse($date);
                $dayMap = [
                    1 => 'mon',
                    2 => 'tue',
                    3 => 'wed',
                    4 => 'thu',
                    5 => 'fri',
                    6 => 'sat',
                    0 => 'sun',
                ];

                $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';
                $q->where('day', $dayKey);
            })
            ->with(['course'])
            ->orderBy('start_time')
            ->get();

        // filter: pilih satu schedule jika user sudah pilih
        $courseIds = $schedules
            ->when($this->scheduleId > 0, function ($collection) {
                return $collection->where('id', $this->scheduleId);
            })
            ->pluck('course_id')
            ->unique()
            ->values();

        $attQuery = Attendance::query()
            ->with(['student'])
            ->where('attendance_date', $date)
            ->whereIn('course_id', $courseIds);

        if ($this->statusFilter !== '') {
            $attQuery->where('status', $this->statusFilter);
        }

        $attendances = $attQuery
            ->orderBy('status')
            ->paginate(25);

        // agar links pagination berfungsi di komponen
        $attendances->withQueryString();


        // rapihin untuk tampilan kartu per course (opsional)
        $selectedCourses = $schedules->keyBy('course_id');

        return view('livewire.dosen-recap', [
            'date' => $date,
            'schedules' => $schedules,
            'attendances' => $attendances,
            'selectedCourses' => $selectedCourses,
        ]);
    }
}

