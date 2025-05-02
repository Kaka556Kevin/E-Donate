<x-filament::page>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Grafik Donasi</h2>
        <canvas id="donasiChart" height="100"></canvas>
    </div>
</x-filament::page>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('donasiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($this->getChartData()['labels']),
                datasets: [{
                    label: 'Donasi Terkumpul (Rp)',
                    data: @json($this->getChartData()['values']),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush