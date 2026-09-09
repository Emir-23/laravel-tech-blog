@extends('layouts.admin')

@section('title', 'Gösterge paneli')
@section('heading', 'Gösterge paneli')

@section('content')
    <div class="mb-6 rounded-xl border border-slate-700 bg-slate-800 p-6 shadow-sm">
        <p class="text-sm text-slate-300">
            Hoş geldiniz, <span class="font-medium text-white">{{ auth()->user()->name }}</span>.
        </p>
        <p class="mt-2 text-sm text-slate-400">
            Sitenizin genel durumuna aşağıdaki özet kartlarından ve grafiklerden göz atabilirsiniz.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600/20 text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Toplam Yazı</p>
                    <p class="text-xl font-semibold text-white">{{ number_format($stats['posts']) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500/20 text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Toplam Kategori</p>
                    <p class="text-xl font-semibold text-white">{{ number_format($stats['categories']) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-500/20 text-cyan-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Toplam Görüntülenme</p>
                    <p class="text-xl font-semibold text-white">{{ number_format($stats['views']) }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-rose-500/20 text-rose-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Toplam Beğeni</p>
                    <p class="text-xl font-semibold text-white">{{ number_format($stats['likes']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold text-white">En çok okunan yazılar</h2>
            <div class="relative h-72">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-slate-700 bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-semibold text-white">Kategori dağılımı</h2>
            <div class="relative h-72">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    (function () {
        Chart.defaults.color = '#cbd5e1';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';
        Chart.defaults.font.family = "'Instrument Sans', ui-sans-serif, system-ui, sans-serif";

        const textColor = '#cbd5e1';
        const gridColor = 'rgba(255, 255, 255, 0.05)';
        const neonFill = 'rgba(59, 130, 246, 0.6)';
        const neonBorder = '#3b82f6';

        const viewsLabels = @json($viewsChart['labels']);
        const viewsData = @json($viewsChart['data']);
        const categoryLabels = @json($categoryChart['labels']);
        const categoryData = @json($categoryChart['data']);

        const truncateLabel = (label, max = 15) => {
            const text = String(label ?? '');
            return text.length > max ? text.slice(0, max) + '...' : text;
        };

        const viewsCtx = document.getElementById('viewsChart');
        if (viewsCtx) {
            new Chart(viewsCtx, {
                type: 'bar',
                data: {
                    labels: viewsLabels,
                    datasets: [{
                        label: 'Görüntülenme',
                        data: viewsData,
                        backgroundColor: neonFill,
                        borderColor: neonBorder,
                        borderWidth: 2,
                        borderRadius: 10,
                        borderSkipped: false,
                        hoverBackgroundColor: 'rgba(59, 130, 246, 0.85)',
                        hoverBorderColor: '#60a5fa',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            borderColor: neonBorder,
                            borderWidth: 1,
                            titleColor: '#fff',
                            bodyColor: textColor,
                            cornerRadius: 10,
                            callbacks: {
                                title: (items) => {
                                    const index = items[0]?.dataIndex ?? 0;
                                    return viewsLabels[index] ?? '';
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: textColor,
                                maxRotation: 40,
                                minRotation: 0,
                                callback: function (value) {
                                    const label = this.getLabelForValue(value);
                                    return truncateLabel(label, 15);
                                },
                            },
                            grid: { color: gridColor, drawBorder: false },
                            border: { display: false },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: textColor, precision: 0 },
                            grid: { color: gridColor, drawBorder: false },
                            border: { display: false },
                        },
                    },
                },
            });
        }

        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            const cyberPalette = [
                '#22d3ee',
                '#3b82f6',
                '#a855f7',
                '#10b981',
                '#06b6d4',
                '#6366f1',
                '#8b5cf6',
                '#34d399',
            ];

            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: categoryLabels.map((_, i) => cyberPalette[i % cyberPalette.length]),
                        borderWidth: 0,
                        hoverOffset: 8,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: textColor,
                                boxWidth: 12,
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            },
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            borderColor: '#22d3ee',
                            borderWidth: 1,
                            titleColor: '#fff',
                            bodyColor: textColor,
                            cornerRadius: 10,
                        },
                    },
                },
            });
        }
    })();
</script>
@endpush
