<?php
$file = 'export.csv';
$handle = fopen($file, 'r');
$data = [];
include('db.php') ;
if ($handle !== false) {
    // Read and discard the first line
    fgets($handle);
    while (($line = fgets($handle)) !== false) {
        // Split the line into fields
        $row = explode(',', trim($line));
        // Select only the columns you're interested in
        $selectedData = [
            'Price' => trim($row[0], '"'),
            'Name' => trim($row[1], '"'),
            'Available' => $row[4],
        ];
        $data[] = $selectedData;
    }
    fclose($handle);
}

foreach ($data as $row) {
    $name = mysqli_real_escape_string($conn, $row['Name']);
    $price = intval($row['Price']);
    $available = intval($row['Available']);
    echo 'item: ' . $name . ' Price: ' . $price . ' Available: ' . $available . PHP_EOL;
    echo '<br>';
    $sql = "SELECT id_item FROM items WHERE name = '" . $name . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_item = $row['id_item'];
        $sql = "INSERT INTO scrap (id_item, price, available) VALUES ($id_item, $price, $available)";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Item not found, creating new item...<br>";
        $sql = "INSERT INTO items (name) VALUES ('" . $name . "')";
        if ($conn->query($sql) === TRUE) {
            echo "New item created successfully<br>";
            $id_item = $conn->insert_id;
            $sql = "INSERT INTO scrap (id_item, price, available) VALUES ($id_item, $price, $available)";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully <br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    echo '############################################# <br>';
}
?>