// resources/js/app.js
import Chart from 'chart.js/auto';
import flatpickr from 'flatpickr';

// Dashboard Chart
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('myChart');
    if (ctx) {
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
    }
});

// Profile Flatpickr
const birthdateInput = document.getElementById('birthdate');
if (birthdateInput) {
    flatpickr(birthdateInput, {
        dateFormat: "d-m-Y",
        defaultDate: birthdateInput.dataset.defaultDate || ''
    });
}

// Print Button
const printButton = document.querySelector('.print-button button');
if (printButton) {
    printButton.addEventListener('click', () => {
        window.print();
    });
}