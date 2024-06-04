$(document).ready(function() {
    var table = $('#itemsTable').DataTable();
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
                    html += '<td>' + data[i].price + '</td>';
                    html += '<td>' + data[i].percentage_difference + '%</td>';
                    html += '<td>' + data[i].average_price + '</td>';
                    html += '<td>' + data[i].available + '</td>';
                    html += '<td></td>';
                    html += '</tr>';
                }
                table.destroy(); // Destruye la tabla existente
                $('#itemsTable tbody').empty().append(html);
                table = $('#itemsTable').DataTable(); // Inicializa DataTables
            },
            error: function() {
                console.log('Error al obtener los items');
            }
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