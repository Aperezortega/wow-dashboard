$(document).ready(function () {
    // Inicializa DataTable correctamente con 25 elementos por defecto
    let dataTable = $('#SaleItemsTable').DataTable({
        "pageLength": 25
    });

    // Función para obtener y mostrar las transacciones
    function getTransactions(type, month) {
        console.log('Fetching transactions...');
        console.log('Type:', type);
        console.log('Month:', month);
        const monthOnly = month.split('-')[1]; // Esto quitará el año y dejará solo el mes

        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: {
                action: 'getTransactions',
                type: type,
                month: monthOnly
            },
            dataType: 'json',
            success: function (data) {
                console.log('Transactions:', data);

                // Limpia el cuerpo de la tabla
                dataTable.clear();

                // Inserta los datos recibidos en la tabla
                data.forEach((transaction, index) => {
                    let amount = transaction.amount ? transaction.amount / 10000 : null;
                    let averagePrice = transaction.averagePrice ? transaction.averagePrice / 10000 : null;
                
                    let className = '';
                    if (amount !== null && averagePrice !== null) {
                        if (amount > 0) { // Venta
                            if (amount > averagePrice) {
                                className = 'green'; // Vendido por encima de la media
                            } else {
                                className = 'red'; // Vendido por debajo de la media
                            }
                        } else { // Compra
                            if (amount < averagePrice) {
                                className = 'green'; // Comprado por debajo de la media
                            } else {
                                className = 'red'; // Comprado por encima de la media
                            }
                        }
                    }
                
                    let rowNode = dataTable.row.add([
                        index + 1,
                        transaction.name,
                        transaction.quantity,
                        new Date(transaction.date).toLocaleDateString('es-ES', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }),
                        averagePrice !== null ? averagePrice.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "--.--",
                        amount !== null ? amount.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "--.--",
                        transaction['%withAverage']
                    ]).draw().node();
                
                    $(rowNode).attr('value', transaction.id_item); // Añadir el atributo value
                    $(rowNode).find('td').eq(6).addClass(className);
                });

                dataTable.draw();
            },
            error: function (error) {
                console.error('Error fetching transactions:', error);
            }
        });
    }

    // Función para obtener el mes seleccionado
    function getSelectedMonth() {
        return $('#month-picker').val();
    }

    // Función para manejar cambios en el mes o los checkboxes
    function updateTransactions() {
        const isSaleChecked = $('#saleCheckbox').is(':checked');
        const isPurchaseChecked = $('#purchaseCheckbox').is(':checked');
        let type;

        if (isSaleChecked && isPurchaseChecked) {
            type = 0; // Ambos seleccionados
        } else if (isSaleChecked) {
            type = 1; // Solo sale seleccionado
        } else if (isPurchaseChecked) {
            type = 2; // Solo purchase seleccionado
        } else {
            type = null; // Ninguno seleccionado, manejar según sea necesario
        }

        const month = getSelectedMonth(); // Asegúrate de que esta función devuelve el mes seleccionado correctamente
        if (type !== null) {
            getTransactions(type, month); // Llama a tu función con los parámetros adecuados
        }
    }

    // Establecer el mes actual como el valor predeterminado del selector de mes
    const currentDate = new Date();
    const currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Asegura el formato MM
    const currentYear = currentDate.getFullYear();
    $('#month-picker').val(`${currentYear}-${currentMonth}`);

    // Eventos para cargar las transacciones basadas en el mes y el tipo seleccionado
    $('#month-picker').change(updateTransactions);
    $('#saleCheckbox, #purchaseCheckbox').change(updateTransactions);

    // Función para agregar o restar meses a una fecha
    function adjustMonth(date, months) {
        var result = new Date(date);
        result.setDate(1); // Establece el día del mes a 1 para evitar desbordamiento
        result.setMonth(result.getMonth() + months);
        return result;
    }

    const minDate = new Date(2024, 4, 1); // Abril de 2024, los meses en JavaScript comienzan en 0
    const maxDate = new Date();
    maxDate.setDate(1); // Ajustar al primer día del mes para comparar solo mes y año
    
    $('#prev-day').click(function() {
        let currentDate = new Date($('#month-picker').val() + "-01");
        let prevMonth = adjustMonth(currentDate, -1);
        if (prevMonth >= minDate) {
            $('#month-picker').val(prevMonth.toISOString().split('T')[0].slice(0, 7)).change();
        } else {
            $('#month-picker').val(minDate.toISOString().split('T')[0].slice(0, 7)).change();
        }
    });
    
    $('#next-day').click(function() {
        let currentDate = new Date($('#month-picker').val() + "-01");
        let nextMonth = adjustMonth(currentDate, 1);
        if (nextMonth <= maxDate) {
            $('#month-picker').val(nextMonth.toISOString().split('T')[0].slice(0, 7)).change();
        } else {
            $('#month-picker').val(maxDate.toISOString().split('T')[0].slice(0, 7)).change();
        }
    });

    // Evento de doble clic en las filas del DataTable
    $('#SaleItemsTable tbody').on('dblclick', 'tr', function() {
        var itemId = $(this).attr('value');
        window.location.href = 'http://localhost/wowscrap/items.php?item=' + itemId;
    });

    // Carga inicial con el mes actual y ambos tipos seleccionados
    updateTransactions();
    $.ajax({
        url: './controller.php',
        type: 'GET',
        data: {
            action: 'getSalesAside'
        },
        dataType: 'json',
        success: function(data) {
            // Asumiendo que 'data' es un objeto con las propiedades necesarias
            // Ejemplo: data = { totalSpent: 1000, totalEarned: 1500, ... }
            $('#generalDataTable tbody').empty(); // Limpiar la tabla antes de rellenarla
            
            // Rellenar la tabla con los nuevos datos
            $('#generalDataTable tbody').append(`
                <tr>
                    <th scope="row">Total spent on purchases:</th>
                    <td>${data.totalSpent}</td>
                </tr>
                <tr>
                    <th scope="row">Total earned from sales:</th>
                    <td>${data.totalEarned}</td>
                </tr>
                <tr>
                    <th scope="row">Difference:</th>
                    <td>${data.difference}</td>
                </tr>
                <tr>
                    <th scope="row">Best-selling item:</th>
                    <td>${data.bestSellingItem}</td>
                </tr>
                <tr>
                    <th scope="row">Most purchased item:</th>
                    <td>${data.mostPurchasedItem}</td>
                </tr>
            `);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching sales data:", error);
        }
    });
});
