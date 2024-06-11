$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var idItem = urlParams.get('item');

    var priceChart;
    var ctx = $('#priceChart')[0].getContext('2d');

    function formatPrice(price) {
        var roundedPrice = Math.round(price).toString();
        var gold = roundedPrice.slice(0, -4);
        var silver = roundedPrice.slice(-4, -2);
        var copper = roundedPrice.slice(-2);
        return `<span class="gold">${gold}</span><span class="silver">${silver}</span><span class="copper">${copper}</span>`;
    }

    function createChart(data, fechas, name) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: name,
                    data: data,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    }
                }
            }
        });
    }

    function updateChart(chart, data, fechas, name) {
        chart.data.datasets.push({
            label: name,
            data: data,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
        });
        chart.update();
    }

    function loadInitialChartData(idItem) {
        $.ajax({
            url: './controller.php',
            method: 'GET',
            data: { action: 'getPriceHistory', idItem: idItem },
            success: function(data) {
                var parsedData = JSON.parse(data);
                var fechas = parsedData.data.map(function(item) {
                    var date = new Date(item.date);
                    return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                });
                var precios = parsedData.data.map(function(item) { return parseFloat(item.price.replace(',', '.')).toFixed(2); });
                if (priceChart) {
                    priceChart.destroy();
                }
                priceChart = createChart(precios, fechas, parsedData.name);
            }
        });
    }

    loadInitialChartData(idItem);

    $.ajax({
        url: './controller.php',
        type: 'GET',
        data: { action: 'getItemData', idItem: idItem },
        success: function(data) {
            var parsedData = JSON.parse(data);

            var formatPrice = function(price) {
                var roundedPrice = Math.round(price).toString();
                var gold = roundedPrice.slice(0, -4);
                var silver = roundedPrice.slice(-4, -2);
                var copper = roundedPrice.slice(-2);
                return `<span class="gold">${gold}</span><span class="silver">${silver}</span><span class="copper">${copper}</span>`;
            };

            $('#dataDisplay').html(`
                <h2>${parsedData.name}</h2>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>Price</th>
                            <th>Cost</th>
                            <th>Profit</th>
                        </tr>
                        <tr>
                            <th>Actual</th>
                            <td>${formatPrice(parsedData.actualPrice)}</td>
                            <td>${formatPrice(parsedData.craftingCost)}</td>
                            <td>${formatPrice(parsedData.actualPrice - parsedData.craftingCost)}</td>
                        </tr>
                        <tr>
                            <th>Average</th>
                            <td>${formatPrice(parsedData.averagePrice)}</td>
                            <td>${formatPrice(parsedData.averageCraftingCost)}</td>
                            <td>${formatPrice(parsedData.averagePrice - parsedData.averageCraftingCost)}</td>
                        </tr>
                        <tr>
                            <th>Min</th>
                            <td>${formatPrice(parsedData.minPrice)}</td>
                            <td>N/A</td>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <th>Max</th>
                            <td>${formatPrice(parsedData.maxPrice)}</td>
                            <td>N/A</td>
                            <td>N/A</td>
                        </tr>
                    </table>
                </div>
            `);
        }
    });

    $.ajax({
        url: './controller.php',
        type: 'GET',
        data: { action: 'getReagents', idItem: idItem },
        success: function(response) {
            var data = JSON.parse(response);

            $("#reagentTree").igTree({
                dataSource: data, 
                singleBranchExpand: false,
                initialExpandDepth: 1,
                dataSourceType: 'json',
                dataSource: $.extend(true, [], data),
                bindings: {
                    textKey: 'text',
                    valueKey: 'quantity', 
                    childDataProperty: 'subreagents'
                },
                expanded: true
            });

        }
    });

    $.ajax({
        url: './controller.php',
        method: 'GET',
        data: { action: 'getItems' },
        success: function(data) {
            var parsedData = JSON.parse(data);
            var itemSearch = $('#itemSearch');
            parsedData.forEach(function(item) {
                var option = $('<option></option>').attr('value', item.id_item).text(item.name);
                itemSearch.append(option);
            });
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!",
                width: "95%"
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed: ", textStatus, errorThrown);
        }
    });

    $('#addItemButton').click(function() {
        var selectedItem = $('#itemSearch').val();
        $.ajax({
            url: './controller.php',
            method: 'GET',
            data: { action: 'getPriceHistory', idItem: selectedItem },
            success: function(data) {
                var parsedData = JSON.parse(data);
                var fechas = parsedData.data.map(function(item) {
                    var date = new Date(item.date);
                    return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                });
                var precios = parsedData.data.map(function(item) { return parseFloat(item.price.replace(',', '.')).toFixed(2); });
                updateChart(priceChart, precios, fechas, parsedData.name);
            }
        });
    });

    $('#clearChartButton').click(function() {
        if (priceChart) {
            priceChart.data.datasets = [];
            priceChart.update();
            loadInitialChartData(idItem);
        }
    });
});
