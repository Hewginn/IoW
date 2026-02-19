@extends('layouts.main')

@section('content')
    <div class="container py-4">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="row g-4">

            <div class="col-md-8">
                <div class="card shadow-sm text-center p-4 h-100">
                    <h2 class="fw-bold">Welcome back!</h2>
                    <img src="{{ asset('image/vineyard.png') }}"
                         class="img-fluid border-2 border-secondary rounded h-100 p-5"
                         alt="Image"
                         style="max-height: 350px; object-fit: contain">
                    <p class="fs-5 text-muted">
                        Here’s a quick overview of your latest sensor data and camera activity.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-header fw-semibold">Latest Image</div>
                    <div class="card-body">
                        <img src="{{ url('/camera-image/' . $image->path) }}" class="img-fluid border-2 border-secondary rounded" alt="Image">
                        <p class="mt-3 fs-5">
                            <strong>{{ $image->camera->name }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            @foreach($data_types as $data_type)
                <div class="col-md-4">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-header fw-semibold">{{ $data_type->data_type }}</div>
                        <div class="card-body">
                            <canvas id="{{ Str::slug($data_type->data_type) . '-gauge' }}"></canvas>
                            <p class="fs-5">
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
                                width: 100,
                                height: 100,
                                yOffset: 30
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

