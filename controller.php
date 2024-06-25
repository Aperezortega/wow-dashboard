<?php
require_once 'db.php';
require_once 'functions.php';
$action = $_GET['action'];
switch ($action) {
    case 'getTypes':
        $types = getTypes($conn);
        echo json_encode($types);
        break;
    case 'getItems':
        $date = isset($_GET['date']) ? $_GET['date'] : null;
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $items = getItems($conn, $date, $type);
        echo json_encode($items);
        break;
    case 'getItemData':
        $idItem = $_GET['idItem'];
        $data = getItemData($conn, $idItem);
        echo json_encode($data);
        break;
    case 'getPriceHistory':
        $idItem = $_GET['idItem'];
        $name = getName($conn, $idItem);
        $data = getPriceHistory($conn, $idItem);
        $response = array('name' => $name, 'data' => $data);
        echo json_encode($response);
        break;
    case 'getReagents':
        $idItem = $_GET['idItem'];
        $reagents = getReagents($conn, $idItem);
        echo json_encode($reagents);
        break;
    case 'getTransactions':
            $type = $_GET['type'];
            $month = $_GET['month'];
            $transactions = getTransactions($conn, $type, $month);
            echo json_encode($transactions);
            break;
    case 'getAsideData':
        $glyphs = getInksForGlyphs($conn);
        $inks = getItems($conn, null, 2);
        foreach ($inks as $key => $ink) {
            $herb = getHerbsForInk($conn, $ink['id_item']);
            //$herbs = $herb;
            $inks[$key]['herbs'] = $herb;
        }
        $response = array('glyphs' => $glyphs, 'inks' => $inks);
        echo json_encode($response);
        break;
    case 'getSalesAside':
        $data = getSalesAside($conn);
        echo json_encode($data);
        break;
    default:
        echo 'default';
        break;
}

?>