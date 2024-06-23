$(document).ready(function () {
    // Inicializa DataTable correctamente, eliminando la inicialización duplicada
    let dataTable = $('#SaleItemsTable').DataTable();

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
                    // Convertir los valores a un formato numérico adecuado
                    let amount = transaction.amount ? transaction.amount / 10000 : null;
                    let averagePrice = transaction.averagePrice ? transaction.averagePrice / 10000 : null;
                
                    // Determinar la clase CSS para la columna '%withAverage'
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
                
                    // Agregar la fila a la tabla
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
                
                    // Aplicar la clase CSS
                    $(rowNode).find('td').eq(6).addClass(className);
                });

                // Redibujar la tabla
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

    // Establecer el mes actual como el valor predeterminado del selector de mes
    const currentDate = new Date();
    const currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Asegura el formato MM
    const currentYear = currentDate.getFullYear();
    $('#month-picker').val(`${currentYear}-${currentMonth}`);

    // Marcar ambos checkboxes (sale y purchase) por defecto
    $('#saleCheckbox').prop('checked', true);
    $('#purchaseCheckbox').prop('checked', true);

    // Eventos para cargar las transacciones basadas en el mes y el tipo seleccionado
    $('#month-picker, #saleCheckbox, #purchaseCheckbox').change(function () {
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
    });

    // Carga inicial con el mes actual y ambos tipos seleccionados
    $('#month-picker').change();
});
