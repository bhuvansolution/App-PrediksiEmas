@extends('dashboard.layouts.app')
@section('container')
    <div class="container monthly-history-container">
        <!-- Filter -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-10 d-flex align-items-center justify-content-between flex-wrap">
                <label for="monthlyStartYear" class="me-2 text-primary fw-medium">Dari Tahun</label>
                <select id="monthlyStartYear" class="form-select me-2" style="width: 100px;">
                    <!-- Isi otomatis dari 1990 -->
                </select>

                <label for="monthlyStartMonth" class="me-2 text-primary fw-medium">Bulan</label>
                <select id="monthlyStartMonth" class="form-select me-2" style="width: 100px;">
                    <!-- Isi bulan 1-12 -->
                </select>

                <label for="monthlyEndYear" class="me-2 text-primary fw-medium">Sampai Tahun</label>
                <select id="monthlyEndYear" class="form-select me-2" style="width: 100px;">
                    <!-- Isi otomatis sampai 2025 -->
                </select>

                <label for="monthlyEndMonth" class="me-2 text-primary fw-medium">Bulan</label>
                <select id="monthlyEndMonth" class="form-select me-2" style="width: 100px;">
                    <!-- Isi bulan 1-12 -->
                </select>

                <button id="monthlyFilterButton" class="btn btn-primary" style="border-radius: 8px;">Filter</button>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="chart-title mb-3 text-primary fw-semibold">Histori Harga Emas Perbulan (1990 -
                    2025) per Kg</h5>
                <div id="monthly-chart-container" class="custom-chart-container">
                    <canvas id="monthlyPriceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const startYearDropdown = document.getElementById("monthlyStartYear");
            const endYearDropdown = document.getElementById("monthlyEndYear");
            const startMonthDropdown = document.getElementById("monthlyStartMonth");
            const endMonthDropdown = document.getElementById("monthlyEndMonth");

            const monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            // Populate year and month dropdowns
            for (let year = 1990; year <= 2025; year++) {
                const startOption = document.createElement("option");
                startOption.value = year;
                startOption.textContent = year;
                startYearDropdown.appendChild(startOption);

                const endOption = document.createElement("option");
                endOption.value = year;
                endOption.textContent = year;
                endYearDropdown.appendChild(endOption);
            }

            for (let month = 1; month <= 12; month++) {
                const startOption = document.createElement("option");
                startOption.value = month;
                startOption.textContent = `${month} - ${monthNames[month - 1]}`;
                startMonthDropdown.appendChild(startOption);

                const endOption = document.createElement("option");
                endOption.value = month;
                endOption.textContent = `${month} - ${monthNames[month - 1]}`;
                endMonthDropdown.appendChild(endOption);
            }

            // Set default values
            startYearDropdown.value = 1990;
            endYearDropdown.value = 2025;
            startMonthDropdown.value = 1;
            endMonthDropdown.value = 12;

            // Automatically load the chart with the default range
            updateMonthlyChart(1990, 1, 2025, 12);

            // Filter button functionality
            document.getElementById("monthlyFilterButton").addEventListener("click", function() {
                const startYear = parseInt(startYearDropdown.value);
                const startMonth = parseInt(startMonthDropdown.value);
                const endYear = parseInt(endYearDropdown.value);
                const endMonth = parseInt(endMonthDropdown.value);

                if (startYear > endYear || (startYear === endYear && startMonth > endMonth)) {
                    alert("Periode awal tidak boleh lebih besar dari periode akhir.");
                    return;
                }

                console.log(`Filter applied: ${startYear}-${startMonth} to ${endYear}-${endMonth}`);
                updateMonthlyChart(startYear, startMonth, endYear, endMonth);
            });

            // Function to update the chart
            function updateMonthlyChart(startYear, startMonth, endYear, endMonth) {
                const chartData = {
                    labels: monthNames,
                    datasets: [{
                        label: "Harga Emas (per Kg)",
                        data: Array.from({
                            length: 12
                        }, () => Math.random() * 1000 + 500), // Example data
                        backgroundColor: "rgba(252, 188, 64, 0.5)",
                        borderColor: "#123458",
                        borderWidth: 2,
                        fill: true,
                    }]
                };

                const ctx = document.getElementById("monthlyPriceChart").getContext("2d");
                if (window.monthlyChartInstance) {
                    window.monthlyChartInstance.destroy();
                }
                window.monthlyChartInstance = new Chart(ctx, {
                    type: "line",
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: "top",
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: "#123458",
                                }
                            },
                            y: {
                                ticks: {
                                    callback: function(value) {
                                        return `$${value}`;
                                    },
                                    color: "#123458",
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
