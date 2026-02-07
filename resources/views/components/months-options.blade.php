@php
            $current = \Carbon\Carbon::create($year, $month, 1);

            $prev = $current->copy()->subMonth();
            $next = $current->copy()->addMonth();
        @endphp
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                {{ $month }} / {{ $year }}
            </h1>
            <p class="text-slate-500">Resumo mensal</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('month.show', [$prev->year, $prev->month]) }}"
            class="px-3 py-2 text-sm bg-slate-100 rounded hover:bg-slate-200">
                ← {{ $prev->format('m/Y') }}
            </a>

            <a href="{{ route('month.show', [$next->year, $next->month]) }}"
            class="px-3 py-2 text-sm bg-slate-100 rounded hover:bg-slate-200">
                {{ $next->format('m/Y') }} →
            </a>
        </div>