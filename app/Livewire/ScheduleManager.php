<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleManager extends Component
{
    use WithPagination;

    public string $searchTerm = '';

    public bool $showForm = false;
    public ?int $editingId = null;

    // form fields
    public string $day = '';
    public string $start_time = '';
    public string $end_time = '';
    public string $room = '';
    public int $course_id = 0;
    public int $user_id = 0; // dosen

    #[Rule('required|in:mon,tue,wed,thu,fri,sat,sun')]
    public string $dayInput = '';

    protected function normalizeDay(string $day): string
    {
        $map = [
            'senin' => 'mon',
            'selasa' => 'tue',
            'rabu' => 'wed',
            'kamis' => 'thu',
            'jumat' => 'fri',
            'sabtu' => 'sat',
            'minggu' => 'sun',
            'mon' => 'mon',
            'tue' => 'tue',
            'wed' => 'wed',
            'thu' => 'thu',
            'fri' => 'fri',
            'sat' => 'sat',
            'sun' => 'sun',
        ];

        $key = strtolower(trim($day));
        return $map[$key] ?? 'mon';
    }

    public function render()
    {
        $schedulesQuery = Schedule::query()->with(['course', 'lecturerUser']);

        if ($this->searchTerm !== '') {
            $schedulesQuery->whereHas('course', function ($q) {
                $q->where('course_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('course_code', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('lecturer', 'like', '%' . $this->searchTerm . '%');
            })->orWhereHas('lecturerUser', function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return view('livewire.schedule-manager', [
            'schedules' => $schedulesQuery->latest()->paginate(10),
            'courses' => Course::orderBy('course_name')->get(),
            'dosens' => User::query()->where('role', 'dosen')->orderBy('name')->get(),
        ]);
    }

    public function openCreateForm(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function openEditForm(int $id): void
    {
        $schedule = Schedule::query()->with('course')->findOrFail($id);
        abort_unless(auth()->guard()->user()?->role === 'admin', 403);

        $this->editingId = $id;
        $this->course_id = (int) $schedule->course_id;
        $this->user_id = (int) $schedule->user_id;
        $this->day = (string) $schedule->day;
        $this->start_time = (string) $schedule->start_time;
        $this->end_time = (string) $schedule->end_time;
        $this->room = (string) $schedule->room;
        $this->dayInput = $schedule->day;

        $this->showForm = true;
    }

    public function save(): void
    {
        abort_unless(auth()->guard()->user()?->role === 'admin', 403);

        $validated = $this->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'user_id' => 'required|integer|exists:users,id',
            'dayInput' => 'required|in:mon,tue,wed,thu,fri,sat,sun',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string|max:100',
        ], [], [
            'dayInput' => 'hari'
        ]);

        // persist
        $data = [
            'course_id' => $validated['course_id'] ?? $this->course_id,
            'user_id' => $validated['user_id'] ?? $this->user_id,
            'day' => $validated['dayInput'] ?? $this->normalizeDay($this->day),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'room' => $this->room,
        ];

        if ($this->editingId) {
            Schedule::query()->where('id', $this->editingId)->update($data);
            $this->dispatch('notify', message: 'Jadwal berhasil diperbarui', type: 'success');
        } else {
            Schedule::query()->create($data);
            $this->dispatch('notify', message: 'Jadwal berhasil ditambahkan', type: 'success');
        }

        $this->showForm = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        abort_unless(auth()->guard()->user()?->role === 'admin', 403);
        Schedule::query()->where('id', $id)->delete();
        $this->dispatch('notify', message: 'Jadwal berhasil dihapus', type: 'success');
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->day = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->room = '';
        $this->course_id = 0;
        $this->user_id = 0;
        $this->editingId = null;
        $this->dayInput = '';
        $this->resetValidation();
    }
}

