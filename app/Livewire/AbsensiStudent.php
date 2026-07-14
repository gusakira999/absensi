<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class AbsensiStudent extends Component
{
    use WithPagination;

    public string $status = 'hadir';

    public function getToday(): Carbon
    {
        return Carbon::today();
    }

    public function schedulesToday(): LengthAwarePaginator
    {
        $today = $this->getToday();
        $dayMap = [
            1 => 'mon', // Monday
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            0 => 'sun', // Sunday
        ];

        $dayKey = $dayMap[$today->dayOfWeek] ?? 'mon';

        return Schedule::query()
            ->where('day', $dayKey)
            ->with(['course'])
            ->orderBy('start_time')
            ->paginate(10);
    }

    private function isScheduleNow(Schedule $schedule): bool
    {

        $now = Carbon::now();

        // start_time/end_time disimpan dalam format H:i:s (sesuai field di database)
        $today = Carbon::today();
        $start = Carbon::parse($today->toDateString().' '.$schedule->start_time);
        $end = Carbon::parse($today->toDateString().' '.$schedule->end_time);

        // inklusif: start <= now <= end
        return $now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end);
    }

    public function checkIn(int $scheduleId): void
    {
        $schedule = Schedule::query()->with(['course'])->findOrFail($scheduleId);

        // jika belum jamnya, blokir
        if (! $this->isScheduleNow($schedule)) {
            $this->dispatch('notify', message: 'Belum jam absen untuk jadwal ini', type: 'error');
            return;
        }

        $userId = (int) auth()->id();

        $attendanceDate = $this->getToday()->toDateString();
        $courseId = (int) $schedule->course_id;

        $existing = Attendance::query()
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('attendance_date', $attendanceDate)
            ->first();

        // Tipe status wajib sesuai enum database
        $this->status = in_array($this->status, ['hadir', 'izin', 'sakit', 'alpha'], true) ? $this->status : 'hadir';

        $payload = [
            'status' => $this->status,
            'check_in_time' => Carbon::now()->format('H:i:s'),
        ];

        if ($existing) {
            $existing->update($payload);
        } else {
            Attendance::query()->create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'attendance_date' => $attendanceDate,
                ...$payload,
            ]);
        }

        $this->dispatch('notify', message: 'Absensi tersimpan', type: 'success');
    }

    public function render()
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $schedules */
        $schedules = $this->schedulesToday();
        $today = $this->getToday()->toDateString();
        $userId = (int) auth()->id();

        $courseIds = $schedules->getCollection()->pluck('course_id')->unique()->values();

        $attendances = Attendance::query()
            ->where('user_id', $userId)
            ->where('attendance_date', $today)
            ->whereIn('course_id', $courseIds)
            ->get()
            ->keyBy('course_id');

        return view('livewire.absensi-student', [
            'schedules' => $schedules,
            'attendances' => $attendances,
        ]);
    }
}


