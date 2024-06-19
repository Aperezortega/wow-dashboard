<?php
include('../db.php');
$filePath = '../AipoxMailLedger.lua'; // Ruta al archivo
$transactions = []; // Array para almacenar las transacciones

// Verificar si el archivo existe
if (file_exists($filePath)) {
    // Abrir el archivo para lectura
    $file = fopen($filePath, "r");
    
    // Verificar si el archivo se abrió correctamente
    if ($file) {
        // Leer el archivo línea por línea
        while (($line = fgets($file)) !== false) {
            // Usar expresiones regulares para extraer los datos
            if (preg_match("/\[(.*?)\] = {/", $line, $matches)) {
                $key = $matches[1]; // Clave única de la transacción
                $transactionData = [];
                
                // Extraer el número entre paréntesis para quantity
                preg_match("/\((\d+)\)/", $key, $quantityMatches);
                $quantity = !empty($quantityMatches) ? intval($quantityMatches[1]) : 1;
                
                // Leer las siguientes líneas para obtener los datos de la transacción
                while (($line = fgets($file)) !== false && !preg_match("/},/", $line)) {
                    if (preg_match("/\[(.*?)\] = (.*?),/", $line, $dataMatches)) {
                        $dataKey = str_replace('"', '', $dataMatches[1]);
                        $dataValue = trim($dataMatches[2], '" ,');
                        $transactionData[$dataKey] = $dataValue;
                    }
                }
                
                // Agregar el campo quantity al array de la transacción
                $transactionData['quantity'] = $quantity;
                
                // Agregar la transacción al array de transacciones
                $transactions[$key] = $transactionData;
            }
        }
        
        // Cerrar el archivo
        fclose($file);
    } else {
        echo "Error al abrir el archivo.";
    }
} else {
    echo "El archivo no existe.";
}
function updateItemsWithIdItem(&$data, $conn) {
    foreach ($data as &$row) {
        if (isset($row['item'])) {
            $name = mysqli_real_escape_string($conn, $row['item']);
        } else {
            // La clave 'item' no existe en $row, manejar según sea necesario
            // Por ejemplo, asignar un valor predeterminado a $name o simplemente continuar
            $name = ""; // Valor predeterminado o manejo de error
        }
        $name = trim($name);
        // Buscar el id_item en la base de datos
        $sql = "SELECT id_item FROM items WHERE name = '".$name."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Si el item existe, obtener el id_item
            $rowDb = $result->fetch_assoc();
            $id_item = $rowDb['id_item'];
        } else {
            // Si el item no existe, insertarlo y obtener el nuevo id_item
            if (strpos($name, "Glyph") !== false) {
                $sql = "INSERT INTO items (name, type) VALUES ('".$name."', 1)";
            } else {
                $sql = "INSERT INTO items (name) VALUES ('".$name."')";
            }
            if ($conn->query($sql) === TRUE) {
                $id_item = $conn->insert_id;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                continue; // Salta a la siguiente iteración si hay un error
            }
        }

        // Actualizar el array con el id_item
        $row['id_item'] = $id_item;
    }
    unset($row); // Romper la referencia al último elemento
}
updateItemsWithIdItem($transactions, $conn);
// Imprimir el array de transacciones para verificar
echo "<pre>";
print_r($transactions);
echo "</pre>";

function insertTransactionsAndDeleteFile($transactions, $filePath) {
    global $conn; // Asegúrate de tener acceso a la conexión de la base de datos
    $allSuccess = true; // Asumir inicialmente que todas las inserciones serán exitosas

    foreach ($transactions as $transaction) {
        $date = date('Y-m-d H:i:s', $transaction['timestamp']);
        $sql = "INSERT INTO transactions (date, type, id_item, quantity, amount) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            echo "Error preparando la sentencia: " . mysqli_error($conn);
            $allSuccess = false; // Marcar como fallida la operación
            break; // Salir del bucle si hay un error
        }

        mysqli_stmt_bind_param($stmt, "ssiii", 
            $date, 
            $transaction['transaction'], 
            $transaction['id_item'], 
            $transaction['quantity'], 
            $transaction['amount']
        );

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error insertando transacción: " . mysqli_stmt_error($stmt) . "<br>";
            $allSuccess = false; // Marcar como fallida la operación
            break; // Salir del bucle si hay un error
        }

        mysqli_stmt_close($stmt);
    }

    if ($allSuccess) {
        if (unlink($filePath)) {
            echo "El archivo ha sido borrado con éxito.<br>";
        } else {
            echo "No se pudo borrar el archivo.<br>";
            $allSuccess = false; // Marcar como fallida la operación si el archivo no se pudo borrar
        }
    }

    return $allSuccess;
}
echo insertTransactionsAndDeleteFile($transactions, $filePath);

?>