<?php
function getTypes($conn) {
    $sql = "SELECT * FROM types";
    $result = $conn->query($sql);
    $types = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $types[$row['id_type']] = $row['name'];
        }
    }
    return $types;
}
function getItems($conn, $date = null, $type = null) {
    if( $type == null & $date == null){
        $sql = "SELECT id_item, name FROM items";
        $result = $conn->query($sql);
        $items = array();
        $items = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $item = array(
                    'id_item' => $row['id_item'],
                    'name' => $row['name'],
                );
                $items[] = $item;
            }
        }
        return $items;
    }else if($date == null){
        $sql = "SELECT id_item, name FROM items where type = $type";
        $result = $conn->query($sql);
        $items = array();
        $items = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $item = array(
                    'id_item' => $row['id_item'],
                    'name' => $row['name'],
                );
                $items[] = $item;
            }
        }
        return $items;
    }
     else if ($type == -1) {
        $sql = "SELECT s.id_item, i.name, s.price, s.available FROM scrap s INNER JOIN items i ON s.id_item = i.id_item WHERE DATE(s.date) = '$date'";
    } else {
        $sql = "SELECT s.id_item, i.name, s.price, s.available FROM scrap s INNER JOIN items i ON s.id_item = i.id_item WHERE DATE(s.date) = '$date' AND i.type = $type";
    }
    $result = $conn->query($sql);
    $items = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $profit = ($row['price'] - getCraftingCost($conn, $row['id_item']));
            $item = array(
                'id_item' => $row['id_item'],
                'name' => $row['name'],
                'price' => $row['price'],
                'percentage_difference' => getPriceDif($conn, $row['id_item'], $date),
                'average_price' => getAveragePrice($conn, $row['id_item']),
                'profit' => $profit,
            );
            $items[] = $item;
        }
    }
    return $items;
}
function getAveragePrice($conn, $id_item){
    $sql = "SELECT AVG(price) as average FROM scrap WHERE id_item = $id_item";
    $result = $conn->query($sql);
    $average = 0;
    if ($result->num_rows > 0) {
        $average = $result->fetch_assoc()['average'];
    }
    return $average;
}
function getMinPrice($conn, $id_item){
    $sql = "SELECT MIN(price) as min FROM scrap WHERE id_item = $id_item";
    $result = $conn->query($sql);
    $min = 0;
    if ($result->num_rows > 0) {
        $min = $result->fetch_assoc()['min'];
    }
    return $min;
}
function getMaxPrice($conn, $id_item){
    $sql = "SELECT MAX(price) as max FROM scrap WHERE id_item = $id_item";
    $result = $conn->query($sql);
    $max = 0;
    if ($result->num_rows > 0) {
        $max = $result->fetch_assoc()['max'];
    }
    return $max;
}
function getActualPrice($conn, $id_item){
    $sql = "SELECT price FROM scrap WHERE id_item = $id_item ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);
    $actual = 0;
    if ($result->num_rows > 0) {
        $actual = $result->fetch_assoc()['price'];
    }
    return $actual;
}   
function getPriceDif($conn, $id_item, $date){
    $sql = "SELECT price FROM scrap WHERE id_item = $id_item AND DATE(date) = '$date'";
    $result = $conn->query($sql);
    $fetchResult = $result->fetch_assoc();
    $todayPrice = $fetchResult ? $fetchResult['price'] : 0;
    $sql = "SELECT price FROM scrap WHERE id_item = $id_item AND DATE(date) = DATE_SUB('$date', INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    $fetchResult = $result->fetch_assoc();
    $previousPrice = $fetchResult ? $fetchResult['price'] : 0;
    return $previousPrice != 0 ? round(($todayPrice - $previousPrice) / $previousPrice * 100, 2) : 0;
}
function getCraftingCost($conn, $id_item){
    $craftingCost = 0;
    $sql = "SELECT id_reagent, quantity FROM architecture WHERE id_item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_item);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($reagent = $result->fetch_assoc()) {
        $sql = "SELECT price FROM scrap WHERE id_item = ? ORDER BY date DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reagent['id_reagent']);
        $stmt->execute();
        $priceResult = $stmt->get_result();
        $priceData = $priceResult->fetch_assoc();
        if ($priceData !== null && isset($priceData['price'])) {
            $craftingCost += $priceData['price'] * $reagent['quantity']; 
        }
    }
    return $craftingCost;
}
function getAverageCraftingCost($conn, $id_item){
    $totalCost = 0;
    $numPrices = 0;
    $sql = "SELECT id_reagent, quantity FROM architecture WHERE id_item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_item);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($reagent = $result->fetch_assoc()) {
        $sql = "SELECT price FROM scrap WHERE id_item = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $reagent['id_reagent']);
        $stmt->execute();
        $priceResult = $stmt->get_result();
        while ($priceData = $priceResult->fetch_assoc()) {
            $totalCost += $priceData['price'] * $reagent['quantity'];
            $numPrices++;
        }
    }
    return $numPrices > 0 ? $totalCost / $numPrices : 0;
}
function getName($conn, $id_item){
    $sql = "SELECT name FROM items WHERE id_item = $id_item";
    $result = $conn->query($sql);
    $name = '';
    if ($result->num_rows > 0) {
        $name = $result->fetch_assoc()['name'];
    }
    return $name;
}
function getItemData($conn, $idItem){
    $data = array();
    $name = getName($conn, $idItem);
    $minPrice = getMinPrice($conn, $idItem);
    $maxPrice = getMaxPrice($conn, $idItem);
    $averagePrice = getAveragePrice($conn, $idItem);
    $actualPrice = getActualPrice($conn, $idItem);
    $craftingCost = getCraftingCost($conn, $idItem);
    $averageCraftingCost = getAverageCraftingCost($conn, $idItem);
    $data = array(
        'name' => $name,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'averagePrice' => $averagePrice,
        'actualPrice' => $actualPrice,
        'craftingCost' => $craftingCost,
        'averageCraftingCost' => $averageCraftingCost
    );
    return $data;

}
function getReagents($conn, $idItem){
    $sql = "SELECT a.id_reagent, a.quantity, i.name, 
            (SELECT price FROM scrap WHERE id_item = a.id_reagent ORDER BY date DESC LIMIT 1) AS price
            FROM architecture a 
            INNER JOIN items i ON a.id_reagent = i.id_item
            WHERE a.id_item = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idItem);
    $stmt->execute();   
    $result = $stmt->get_result();
    $reagents = [];
    while ($row = $result->fetch_assoc()) {
        $price = $row['price'] ? $row['price'] : 0;
        $price = number_format($price / 10000, 2, ',', '');
        $row['text'] = $row['name'] . ' - ' . $row['quantity'] . ' - ' . $price;
        $row['subreagents'] = getReagents($conn, $row['id_reagent']);
        $reagents[] = $row;
    }

    return $reagents;
}
function getPriceHistory($conn, $idItem){
    $sql = "SELECT date, price FROM scrap WHERE id_item = ? ORDER BY date";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idItem);
    $stmt->execute();
    $result = $stmt->get_result();
    $priceHistory = [];
    while ($row = $result->fetch_assoc()) {
        $priceHistory[] = array(
            'date' => $row['date'],
            'price' => number_format($row['price'] / 10000, 2, ',', '')
        );
    }
    return $priceHistory;
}
function getInksForGlyphs($conn, $amount = 10){
    $sql = " SELECT i.name, i.id_item
        FROM items i
        JOIN scrap s ON i.id_item = s.id_item
        WHERE DATE(s.date) = CURDATE() AND i.`type` = 1
        ORDER BY s.price DESC
        LIMIT $amount";  
    $result = $conn->query($sql);
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT name FROM items WHERE id_item IN (SELECT id_reagent FROM architecture WHERE id_item = ".$row['id_item'] .") AND TYPE = 2";
        $resultInk = $conn->query($sql);
        $ink = $resultInk->fetch_assoc()['name'];
        $items[] = array(
            'Glyph' => $row['name'],
            'Ink' => $ink
        );
    }
    return $items;
}
function getHerbsForInk($conn, $idInk, $boolean = true){
    if($boolean){
        $sql = "SELECT i.name FROM architecture a INNER JOIN items i ON
        a.id_reagent = i.id_item INNER JOIN scrap s ON a.id_reagent = s.id_item WHERE
        a.id_item = 
            (
            SELECT id_reagent FROM architecture WHERE id_item = ?
            )
            AND date(DATE) = CURDATE() ORDER BY s.price LIMIT 1";
    } else {
        $sql ="SELECT i.name FROM architecture a INNER JOIN items i ON a.id_reagent = i.id_item WHERE a.id_item = (
            SELECT id_reagent FROM architecture WHERE id_item = ?
            )";
    }


    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Manejar error aquí, por ejemplo:
        return "Error preparing statement: " . $conn->error;
    }
    $stmt->bind_param("i", $idInk);
    if (!$stmt->execute()) {
        return "Error executing query: " . $stmt->error;
    }

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $herb = $row['name'];
    }
    $stmt->close();

    return $herb;
}
function getTransactions($conn, $type, $month){
    $sql = '';
    switch ($type) {
        case '0':
            $sql = "SELECT i.name, t.quantity, t.date, t.amount, t.id_item, t.type FROM transactions t INNER JOIN
             items i ON t.id_item = i.id_item 
             WHERE MONTH(t.date) = ? AND YEAR(t.date) = YEAR(CURRENT_DATE())";
            break;
        case '1':
            $sql = "SELECT i.name, t.quantity, t.date, t.amount, t.id_item, t.type FROM transactions t INNER JOIN
             items i ON t.id_item = i.id_item 
             WHERE  type = 'seller' AND  MONTH(t.date) = ? AND YEAR(t.date) = YEAR(CURRENT_DATE())";
            break;
        case '2':
            $sql = "SELECT i.name, t.quantity, t.date, t.amount, t.id_item, t.type FROM transactions t INNER JOIN
             items i ON t.id_item = i.id_item 
             WHERE  type = 'buyer' AND MONTH(t.date) = ? AND YEAR(t.date) = YEAR(CURRENT_DATE())";
            break;
        default:
            break;
    }
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Manejar error aquí, por ejemplo:
        return "Error preparing statement: " . $conn->error;
    }
    $stmt->bind_param("i", $month);
    if (!$stmt->execute()) {
        return "Error executing query: " . $stmt->error;
    }
    $transactions = [];
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
       
        if ($row['type'] === 'buyer') {
    
            $row['amount'] = -$row['amount']; 
        } else if ($row['type'] === 'seller') {
            $row['amount'] = $row['amount']; 
        }
        // Añadir campos adicionales
        $row['averagePrice'] = getAveragePrice($conn, $row['id_item']);
        $row['averagePrice'] = floor($row['averagePrice']);
        if (isset($row['amount']) && isset($row['averagePrice']) && $row['averagePrice'] != 0) {
            $row['%withAverage'] = ((abs($row['amount']) - $row['averagePrice']) / $row['averagePrice']) * 100;
            $row['%withAverage'] = round($row['%withAverage'], 2);
        } else {
            $row['%withAverage'] = 0;
        }
        $transactions[] = $row;
    }
    return $transactions;
}

include 'db.php';
$sql = "select * from scrap where id_item = 545 and date(date) = '2024-06-20'";
$result = $conn->query($sql);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}
echo '<pre>';
print_r($data);
echo '<br>';
$itemData = getItemData($conn, 545);
echo '<pre>';
print_r($itemData);
echo '<br>';
$sql = "SELECT * FROM transactions WHERE id_item = 545";
$result = $conn->query($sql);
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}
echo '<pre>';
print_r($data);
echo '<br>';
?>