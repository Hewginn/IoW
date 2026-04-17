@extends('layouts.main')

@section('content')
    <div class="container py-4">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="row g-2">

            <!-- Welcome card -->
            <div class="col-12 col-md-8">
                <div class="card shadow-sm text-center p-2 h-100">
                    <h5 class="fw-bold">Welcome back!</h5>

                    <img src="{{ asset('image/vineyard.png') }}"
                         class="img-fluid border-1 border-secondary rounded p-2"
                         style="max-height: 180px; object-fit: contain">

                    <p class="small text-muted mb-0">
                        Quick overview of your latest sensor data.
                    </p>
                </div>
            </div>

            <!-- Image card -->
            @if($image)
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-header py-1 small fw-semibold">Latest Image</div>
                        <div class="card-body p-2">
                            <img src="{{ url('/camera-image/' . $image->path) }}"
                                 class="img-fluid rounded"
                                 style="max-height: 150px; object-fit: cover">

                            <p class="mt-2 small mb-0">
                                <strong>{{ $image->camera->name }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Data cards -->
            @foreach($data_types as $data_type)
                <div class="col-6 col-md-4 col-lg-4">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-header py-1 small fw-semibold">
                            {{ $data_type->data_type }}
                        </div>

                        <div class="card-body p-2">
                            <canvas id="{{ Str::slug($data_type->data_type) . '-gauge' }}"
                                    style="max-height: 120px;"></canvas>

                            <p class="small mb-0">
                                <strong>{{ $latest_values[$data_type->id]->value . " " . $data_type->unit }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script>

        const gaugeImagePlugin = {
            id: 'gaugeImage',
            afterDraw(chart, args, options) {
                const { ctx, chartArea } = chart;
                const img = options.image; // already preloaded

                const x = (chartArea.left + chartArea.right) / 2 - options.width / 2;
                const y = ((chartArea.top + chartArea.bottom) / 2 - options.height / 2) + (options.yOffset || 0);

                ctx.drawImage(img, x, y, options.width, options.height);
            }
        };


        Chart.register(gaugeImagePlugin)

        function createGauge(canvasId, value, maxValue, color, imageSrc) {

            const img = new Image();
            img.src = imageSrc;

            img.onload = () => {
                const ctx = document.getElementById(canvasId).getContext('2d');

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [value, maxValue - value],
                            backgroundColor: [color, '#e9ecef'],
                            borderWidth: 0,
                            cutout: '70%',
                            circumference: 180,
                            rotation: 270
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: { enabled: false },
                            legend: { display: false },
                            gaugeImage: {
                                image: img,   // pass preloaded image
                                width: 60,
                                height: 60,
                                yOffset: 10
                            }
                        }
                    }
                });
            };
        }


        document.addEventListener("DOMContentLoaded", function () {
            @foreach($data_types as $data_type)
                createGauge(
                    "{{ Str::slug($data_type->data_type) . '-gauge' }}",
                    {{ $latest_values[$data_type->id]->value }},
                    {{ $data_type->max }},
                    '#1e90ff',
                    "{{ asset('storage/' . $data_type->image_path) }}"
                );
            @endforeach
        });
    </script>

@endsection

