$(document).ready(function() {
    var table = $('#itemsTable').DataTable();
    fetchItemsAndInks();
    function getItems() {
        var date = $('#date-picker').val();
        var type = $('#typeSelector').val();
        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: { action: 'getItems', date: date, type: type },
            success: function(response) {
                console.log(response);
                var data = JSON.parse(response);
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr value="' + data[i].id_item + '">';
                    html += '<td>' + (i+1) + '</td>';
                    html += '<td>' + data[i].name + '</td>';
                    var averagePrice = (data[i].average_price / 10000).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    html += '<td>' + averagePrice + '</td>';
                    var price = (data[i].price / 10000).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    html += '<td>' + price + '</td>';
                    var percentageClass = data[i].percentage_difference < 0 ? 'negative' : 'positive';
                    html += '<td class="' + percentageClass + '">' + data[i].percentage_difference + '%</td>';
                    var profit = (data[i].profit / 10000).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    html += '<td>' + profit + '</td>';
                    html += '<td></td>';
                    html += '</tr>';
    }
                table.destroy(); 
                $('#itemsTable tbody').empty().append(html);
                table = $('#itemsTable').DataTable({
                    pageLength: 25
                }); 
                $(document).on('dblclick', '#itemsTable tbody tr', function() {
                    var itemId = $(this).attr('value');
                    window.location.href = 'http://localhost/wowscrap/items.php?item=' + itemId;
                });
            },
            error: function() {
                console.log('Error al obtener los items');
            }
        });
    }
    function fetchItemsAndInks() {
        // Realizar la llamada AJAX
        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: { action: 'getAsideData'},
            dataType: 'json',
            success: function(data) {
                console.log('####################################');
                console.log(data);
                // Asumiendo que `data` tiene dos propiedades: items y inks
                fillTable('#top10', data.glyphs, ['Glyph', 'Ink']);
                fillTable('#cheapestHerbs', data.inks, ['name', 'herbs']);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
    
    function fillTable(tableId, data, columns) {
        const $tableBody = $(tableId).find('tbody');
        $tableBody.empty(); // Limpiar el cuerpo de la tabla antes de llenarlo
    
        $.each(data, function(index, row) {
            const $tr = $('<tr></tr>');
            $.each(columns, function(i, col) {
                const $td = $('<td></td>').text(row[col]);
                $tr.append($td);
            });
            $tableBody.append($tr);
        });
    }
    $.ajax({
        url: './controller.php', 
        type: 'GET',
        data: { action: 'getTypes' },
        success: function(response) {
            var types = JSON.parse(response);
            $('#typeSelector').append('<option value="-1">All</option>');
            $.each(types, function(id, name) {
                $('#typeSelector').append('<option value="' + id + '">' + name + '</option>');
            });
            var today = new Date().toISOString().split('T')[0];
            $('#date-picker').attr('max', today);
            $('#date-picker').val(today);

            $('#prev-day').click(function() {
                var date = $('#date-picker').val();
                var prevDay = new Date(date);
                prevDay.setDate(prevDay.getDate() - 1);
                $('#date-picker').val(prevDay.toISOString().split('T')[0]);
                getItems();
            });

            $('#next-day').click(function() {
                var date = $('#date-picker').val();
                var nextDay = new Date(date);
                if (nextDay.toISOString().split('T')[0] < today) {
                    nextDay.setDate(nextDay.getDate() + 1);
                    $('#date-picker').val(nextDay.toISOString().split('T')[0]);
                    getItems();
                }
            });
            getItems();
            $('#date-picker, #typeSelector').change(getItems);
            
        },
        error: function() {
            console.log('Error al obtener los tipos');
        }
    });
});