<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function courses()
    {
        $mahasiswaId = Auth::id();
        
        // Get courses yang mahasiswa ini punya attendance records
        return Course::whereIn('id', function($query) use ($mahasiswaId) {
            $query->selectRaw('DISTINCT course_id')
                ->from('attendances')
                ->where('user_id', $mahasiswaId);
        })->paginate(10);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Mata Kuliah Saya</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Daftar mata kuliah yang Anda ikuti</flux:subheading>
    <flux:separator variant="subtle" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($this->courses as $course)
            <flux:card class="p-6 space-y-3 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <flux:heading size="md" class="text-zinc-900 dark:text-white">
                            {{ $course->course_name }}
                        </flux:heading>
                        <flux:text class="text-zinc-600 dark:text-zinc-400 text-sm">
                            {{ $course->course_code }}
                        </flux:text>
                    </div>
                    <flux:badge size="sm" color="blue">
                        Sem {{ $course->semester }}
                    </flux:badge>
                </div>

                <flux:separator variant="subtle" />

                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <flux:icon icon="user" class="w-4 h-4 text-zinc-500" />
                        <span class="text-zinc-600 dark:text-zinc-400">
                            {{ $course->lecturer }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon icon="check-circle" class="w-4 h-4 text-zinc-500" />
                        <span class="text-zinc-600 dark:text-zinc-400">
                            {{ $course->attendances->where('user_id', auth()->id())->count() }} Absensi
                        </span>
                    </div>
                </div>

                <flux:separator variant="subtle" />

                <div class="flex gap-2 pt-2">
                    <flux:button variant="outline" size="sm" class="flex-1" href="{{ route('mahasiswa.absensi') }}" wire:navigate>
                        Absensi
                    </flux:button>
                    <flux:button variant="outline" size="sm" class="flex-1">
                        Detail
                    </flux:button>
                </div>
            </flux:card>
        @empty
            <div class="col-span-full py-12 text-center">
                <flux:icon icon="inbox" class="w-12 h-12 mx-auto mb-4 text-zinc-400" />
                <flux:heading size="md" class="text-zinc-600 dark:text-zinc-400 mb-2">
                    Belum ada mata kuliah
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Anda belum terdaftar di mata kuliah apapun
                </flux:text>
            </div>
        @endforelse
    </div>
</div>
