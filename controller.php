<?php
require_once 'db.php';

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
function getItems($conn, $date, $type) {
    if ($type == -1) {
        $sql = "SELECT s.id_item, i.name, s.price, s.available FROM scrap s INNER JOIN items i ON s.id_item = i.id_item WHERE DATE(s.date) = '$date'";
    } else {
        $sql = "SELECT s.id_item, i.name, s.price, s.available FROM scrap s INNER JOIN items i ON s.id_item = i.id_item WHERE DATE(s.date) = '$date' AND i.type = $type";
    }
    $result = $conn->query($sql);
    $items = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item = array(
                'id_item' => $row['id_item'],
                'name' => $row['name'],
                'price' => $row['price'],
                'percentage_difference' => getPriceDif($conn, $row['id_item'], $date),
                'average_price' => getAveragePrice($conn, $row['id_item']),
                'available' => $row['available']
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

$action = $_GET['action'];
switch ($action) {
    case 'getTypes':
        $types = getTypes($conn);
        echo json_encode($types);
        break;
    case 'getItems':
        $date = $_GET['date'];
        $type = $_GET['type'];
        $items = getItems($conn, $date, $type);
        echo json_encode($items);
        break;
    case 'put':
        echo 'put';
        break;
    case 'delete':
        echo 'delete';
        break;
    default:
        echo 'default';
        break;
}

?>