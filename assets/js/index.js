$(document).ready(function() {

    // Declaración de variables
    var table = initializeDataTable();
    const today = new Date().toISOString().split('T')[0];

    // Inicializar componentes y eventos
    initializeDatePicker();
    initializeTypeSelector();
    setupEventHandlers();
    fetchItemsAndInks();
    getItems();

    // Funciones

    function initializeDatePicker() {
        $('#date-picker').attr('max', today);
        $('#date-picker').val(today);
    }

    function initializeTypeSelector() {
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
            },
            error: function() {
                console.log('Error al obtener los tipos');
            }
        });
    }

    function setupEventHandlers() {
        $('#date-picker, #typeSelector').change(getItems);

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

        $(document).on('dblclick', '#itemsTable tbody tr', function() {
            var itemId = $(this).attr('value');
            window.location.href = 'http://localhost/wow-dashboard/items.php?item=' + itemId;
        });
    }

    function initializeDataTable() {
        return $('#itemsTable').DataTable({
            pageLength: 25
        });
    }

    function getItems() {
        var date = $('#date-picker').val();
        var type = $('#typeSelector').val();
        type = type === null || type === undefined || type === "" ? -1 : type; // Asegurarse de que `type` tenga un valor válido
        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: { action: 'getItems', date: date, type: type },
            success: handleItemsSuccess,
            error: function() {
                console.log('Error al obtener los items');
            }
        });
    }

    function handleItemsSuccess(response) {
        var data = JSON.parse(response);
        console.log('Items:', data);
        table.clear();

        data.forEach((item, index) => {
            const averagePrice = item.average_price / 10000;
            const price = item.price / 10000;
            const profit = item.profit / 10000;
            const percentageClass = item.percentage_difference < 0 ? 'negative' : 'positive';

            const rowNode = table.row.add([
                index + 1,
                item.name,
                formatNumber(averagePrice),
                formatNumber(price),
                item.percentage_difference + '%',
                formatNumber(profit),
                item.sold
            ]).draw().node();

            $(rowNode).attr('value', item.id_item);
            $(rowNode).find('td').eq(4).addClass(percentageClass);
        });

        table.draw();
    }

    function formatNumber(number) {
        return number.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function fetchItemsAndInks() {
        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: { action: 'getAsideData'},
            dataType: 'json',
            success: function(data) {
                console.log('####################################');
                console.log(data);
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
        $tableBody.empty();
    
        $.each(data, function(index, row) {
            const $tr = $('<tr></tr>');
            $.each(columns, function(i, col) {
                const $td = $('<td></td>').text(row[col]);
                $tr.append($td);
            });
            $tableBody.append($tr);
        });
    }
});
