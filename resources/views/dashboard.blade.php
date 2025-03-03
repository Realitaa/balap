<x-app-layout>
    <x-slot:page>Dashboard</x-slot:page>

    <div class="container">
        <h1>Halo, {{ Auth::user()->name }}!</h1>
        <div class="text-center">
        <div class="card m-5" style="max-height: 500px;">
            <canvas id="myChart"></canvas>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        </script>
</x-app-layout>
