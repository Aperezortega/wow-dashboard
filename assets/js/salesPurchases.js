$(document).ready(function () {

    const currentDate = new Date();
    const currentMonth = ("0" + (currentDate.getMonth() + 1)).slice(-2);
    const currentYear = currentDate.getFullYear();
    const dataTable = initializeDataTable();

    // Setup event handlers for month-picker and checkboxes
    $('#month-picker').change(updateTransactions);
    $('#saleCheckbox, #purchaseCheckbox').change(updateTransactions);
    $('#prev-day').click(handlePrevMonth);
    $('#next-day').click(handleNextMonth);
    $('#SaleItemsTable tbody').on('dblclick', 'tr', handleRowDoubleClick);
    $('#month-picker').val(`${currentYear}-${currentMonth}`);
    updateTransactions();
    fetchSalesAside();

    // Initialize DataTable with 25 items per page
    function initializeDataTable() {
        return $('#SaleItemsTable').DataTable({
            "pageLength": 25
        });
    }
    
    /**
    *  Functions
    **/

    // Fetch and display transactions based on type and month
    function getTransactions(type, month) {
        console.log('Fetching transactions...', 'Type:', type, 'Month:', month);
        const monthOnly = month.split('-')[1];

        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: {
                action: 'getTransactions',
                type: type,
                month: monthOnly
            },
            dataType: 'json',
            success: handleTransactionsSuccess,
            error: function (error) {
                console.error('Error fetching transactions:', error);
            }
        });
    }

    // Handle successful transactions data fetch
    function handleTransactionsSuccess(data) {
        console.log('Transactions:', data);
        dataTable.clear();

        data.forEach((transaction, index) => {
            const amount = transaction.amount ? transaction.amount / 10000 : null;
            const averagePrice = transaction.averagePrice ? transaction.averagePrice / 10000 : null;
            const className = getClassName(amount, averagePrice);

            const rowNode = dataTable.row.add([
                index + 1,
                transaction.name,
                transaction.quantity,
                formatDate(transaction.date),
                formatNumber(averagePrice),
                formatNumber(amount),
                transaction['%withAverage']
            ]).draw().node();

            $(rowNode).attr('value', transaction.id_item);
            $(rowNode).find('td').eq(6).addClass(className);
        });

        dataTable.draw();
    }

    // Get class name based on amount and average price
    function getClassName(amount, averagePrice) {
        if (amount !== null && averagePrice !== null) {
            if (amount > 0) {
                return amount > averagePrice ? 'green' : 'red';
            } else {
                return amount < averagePrice ? 'green' : 'red';
            }
        }
        return '';
    }

    // Format date to 'dd-mm-yyyy'
    function formatDate(date) {
        return new Date(date).toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    // Format number with 2 decimal places
    function formatNumber(number) {
        return number !== null ? number.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "--.--";
    }

    // Get selected month from month-picker
    function getSelectedMonth() {
        return $('#month-picker').val();
    }

    // Update transactions based on selected checkboxes and month
    function updateTransactions() {
        const type = getSelectedType();
        const month = getSelectedMonth();

        if (type !== null) {
            getTransactions(type, month);
        }
    }

    // Get selected type based on checkboxes
    function getSelectedType() {
        const isSaleChecked = $('#saleCheckbox').is(':checked');
        const isPurchaseChecked = $('#purchaseCheckbox').is(':checked');

        if (isSaleChecked && isPurchaseChecked) {
            return 0; // Both selected
        } else if (isSaleChecked) {
            return 1; // Only sale selected
        } else if (isPurchaseChecked) {
            return 2; // Only purchase selected
        } else {
            return null; // None selected
        }
    }

    // Adjust month by a given number of months
    function adjustMonth(date, months) {
        const result = new Date(date);
        result.setDate(1);
        result.setMonth(result.getMonth() + months);
        return result;
    }

    // Handle previous month button click
    function handlePrevMonth() {
        const currentDate = new Date($('#month-picker').val() + "-01");
        const prevMonth = adjustMonth(currentDate, -1);
        const minDate = new Date(2024, 3, 1);

        if (prevMonth >= minDate) {
            $('#month-picker').val(formatDateForPicker(prevMonth)).change();
        } else {
            $('#month-picker').val(formatDateForPicker(minDate)).change();
        }
    }

    // Handle next month button click
    function handleNextMonth() {
        const currentDate = new Date($('#month-picker').val() + "-01");
        const nextMonth = adjustMonth(currentDate, 1);
        const maxDate = new Date();
        maxDate.setDate(1);

        if (nextMonth <= maxDate) {
            $('#month-picker').val(formatDateForPicker(nextMonth)).change();
        } else {
            $('#month-picker').val(formatDateForPicker(maxDate)).change();
        }
    }

    // Format date for month-picker input
    function formatDateForPicker(date) {
        return date.toISOString().split('T')[0].slice(0, 7);
    }

    // Handle double click on DataTable row
    function handleRowDoubleClick() {
        const itemId = $(this).attr('value');
        window.location.href = 'http://localhost/wowscrap/items.php?item=' + itemId;
    }

    // Fetch and display sales aside data
    function fetchSalesAside() {
        $.ajax({
            url: './controller.php',
            type: 'GET',
            data: {
                action: 'getSalesAside'
            },
            dataType: 'json',
            success: handleSalesAsideSuccess,
            error: function (xhr, status, error) {
                console.error("Error fetching sales data:", error);
            }
        });
    }

    // Handle successful sales aside data fetch
    function handleSalesAsideSuccess(data) {
        $('#generalDataTable tbody').empty();
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
    }
});
