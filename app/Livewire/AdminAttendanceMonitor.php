<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class AdminAttendanceMonitor extends Component
{
    use WithPagination;

    public string $dateFrom = '';

    public string $dateTo = '';

    public string $statusFilter = '';

    public int $courseId = 0;

    public string $searchTerm = '';

    public function mount(): void
    {
        $today = Carbon::today()->toDateString();
        $this->dateFrom = $today;
        $this->dateTo = $today;
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['dateFrom', 'dateTo', 'statusFilter', 'courseId', 'searchTerm'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $today = Carbon::today()->toDateString();
        $this->dateFrom = $today;
        $this->dateTo = $today;
        $this->statusFilter = '';
        $this->courseId = 0;
        $this->searchTerm = '';
        $this->resetPage();
    }

    protected function baseQuery(): Builder
    {
        $query = Attendance::query()
            ->with(['student', 'course']);

        if ($this->dateFrom !== '') {
            $query->whereDate('attendance_date', '>=', $this->dateFrom);
        }

        if ($this->dateTo !== '') {
            $query->whereDate('attendance_date', '<=', $this->dateTo);
        }

        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->courseId > 0) {
            $query->where('course_id', $this->courseId);
        }

        if ($this->searchTerm !== '') {
            $term = '%' . $this->searchTerm . '%';
            $query->whereHas('student', function (Builder $q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('nim', 'like', $term);
            });
        }

        return $query;
    }

    /**
     * @return array{total: int, hadir: int, izin: int, sakit: int, alpha: int, presence_pct: float}
     */
    protected function stats(): array
    {
        $rows = $this->baseQuery()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = (int) $rows->sum();
        $hadir = (int) ($rows['hadir'] ?? 0);
        $izin = (int) ($rows['izin'] ?? 0);
        $sakit = (int) ($rows['sakit'] ?? 0);
        $alpha = (int) ($rows['alpha'] ?? 0);

        $presencePct = $total > 0 ? round(($hadir / $total) * 100, 1) : 0.0;

        return compact('total', 'hadir', 'izin', 'sakit', 'alpha', 'presencePct');
    }

    public function render()
    {
        $attendances = $this->baseQuery()
            ->orderByDesc('attendance_date')
            ->orderByDesc('created_at')
            ->paginate(20);

        $attendances->withQueryString();

        return view('livewire.admin-attendance-monitor', [
            'attendances' => $attendances,
            'courses' => Course::query()->orderBy('course_name')->get(),
            'stats' => $this->stats(),
        ]);
    }
}
