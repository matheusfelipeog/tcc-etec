// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

function gerar_grafico_tipos_pagamento(myPieChart, data) {
  new Chart(myPieChart, {
    type: 'doughnut',
    data: {
      labels: ["Crédito", "Débito", "Dinheiro"],
      datasets: [{
        data: data,
        backgroundColor: ['#4e73df', '#36b9cc', '#1cc88a',],
        hoverBackgroundColor: ['#2e59d9', '#2c9faf', '#17a673'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 5,
        xPadding: 15,
        yPadding: 15,
        displayColors: true,
        caretPadding: 10,
      },
      legend: {
        display: true
      },
      cutoutPercentage: 80,
    },
  });
}



