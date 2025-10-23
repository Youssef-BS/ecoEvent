<div class="container-fluid">

    <!-- Title -->
    <div class="title-wrapper pt-30 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>Dashboard </h2>
            </div>

        </div>
    </div>

    <!-- Cards -->

    <div class="row g-3">
        <!-- Total Sponsors -->
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="icon-card mb-30 p-4 shadow-sm" style="border-radius:12px; background-color:#ffffff; min-height:180px; display:flex; align-items:center;">
                <div class="icon me-3" style="font-size:40px; color:#6a1b9a;">
                    <i class="lni lni-users"></i>
                </div>
                <div class="content">
                    <h6 class="text-muted">Total Sponsors</h6>
                    <h3 class="text-bold">{{ $totalSponsors }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Resources -->
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="icon-card mb-30 p-4 shadow-sm" style="border-radius:12px; background-color:#ffffff; min-height:180px; display:flex; align-items:center;">
                <div class="icon me-3" style="font-size:40px; color:#0288d1;">
                    <i class="lni lni-briefcase"></i>
                </div>
                <div class="content">
                    <h6 class="text-muted">Total Resources</h6>
                    <h3 class="text-bold">{{ $totalResources }}</h3>
                </div>
            </div>
        </div>

        <!-- Events Sponsored -->
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="icon-card mb-30 p-4 shadow-sm" style="border-radius:12px; background-color:#ffffff; min-height:180px; display:flex; align-items:center;">
                <div class="icon me-3" style="font-size:40px; color:#f57c00;">
                    <i class="lni lni-calendar"></i>
                </div>
                <div class="content">
                    <h6 class="text-muted">Events Sponsored</h6>
                    <h3 class="text-bold">{{ $totalEventsSponsored }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mt-4 g-3">
        <div class="col-lg-6">
            <div class="card-style mb-30 p-3" style="border-radius:12px; background-color:#ffffff; min-height:350px;">
                <h6>Ressources par Sponsor</h6>
                <canvas id="chartResources" height="250"
                    style="max-height:250px;"
                    data-labels="{{ implode(',', $sponsorsLabels) }}"
                    data-values="{{ implode(',', $resourcesCount) }}"></canvas>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-style mb-30 p-3" style="border-radius:12px; background-color:#ffffff; min-height:350px;">
                <h6>Sponsors par Performance</h6>
                <canvas id="chartPerformance" height="250"
                    style="max-height:250px;"
                    data-labels="{{ implode(',', $performanceLabels) }}"
                    data-values="{{ implode(',', $performanceData) }}"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function parseData(canvas) {
            const labels = canvas.dataset.labels.split(',');
            const values = canvas.dataset.values.split(',').map(v => parseFloat(v));
            return {
                labels,
                values
            };
        }

        function createChart(canvas, type, labels, data) {
            const pastelColors = ['#ffcc80', '#b39ddb', '#81d4fa', '#a5d6a7', '#f48fb1', '#fff176', '#90caf9'];
            const ctx = canvas.getContext('2d');

            return new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: '',
                        data: data,
                        backgroundColor: type === 'pie' ? pastelColors.slice(0, data.length) : pastelColors[0],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#000'
                            }
                        }
                    },
                    scales: type === 'bar' ? {
                        x: {
                            ticks: {
                                color: '#000'
                            },
                            grid: {
                                color: '#e0e0e0'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#000'
                            },
                            grid: {
                                color: '#e0e0e0'
                            }
                        }
                    } : {}
                }
            });
        }

        const charts = [{
                id: 'chartResources',
                type: 'bar'
            },
            {
                id: 'chartPerformance',
                type: 'pie'
            }
        ];

        charts.forEach(c => {
            const canvas = document.getElementById(c.id);
            if (!canvas) return;
            const {
                labels,
                values
            } = parseData(canvas);
            createChart(canvas, c.type, labels, values);
        });

    });
</script>