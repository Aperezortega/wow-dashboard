<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');
include('db.php');
ini_set('display_errors', 1);
function logMessage($message) {
    $logFile = 'log.txt';
    $currentTime = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$currentTime] $message\n", FILE_APPEND);
}

function getName($id){
    $baseUrl = 'https://www.wowhead.com/cata/item=';
    $searchUrl = $baseUrl . $id;
    $html = file_get_html($searchUrl);
    $titleNode = $html->find('title', 0);
    $title = $titleNode->innertext; // Obtén el texto dentro del nodo
    $name = explode('-', $title)[0];
    $name = trim($name);
    return $name;
}
function getReagents($itemName){
    $reagents = [];
    $baseUrl = 'https://www.wowhead.com/cata/search?q=';
    $parseItem = str_replace(' ', '+', $itemName);
    $searchUrl = $baseUrl . $parseItem;
    $html = file_get_html($searchUrl);

    foreach ($html->find('script[type=application/json]') as $script) {
        $json = json_decode($script->innertext, true);
        if (isset($json[0]['reagents'])) {
            $data = $json[0]['reagents'];
            break;
        }
    }

    if (isset($data)) {
        foreach ($data as $reagent) {
            $itemId = $reagent[0];
            $quantity = $reagent[1];
            $reagents[] = [
                'name' => getName($itemId),
                'quantity' => $quantity,
            ];
            logMessage('LINE 38: REAGENT FOUND FOR ITEM ' . getName($itemId) . ' WITH QUANTITY ' . $quantity);
        }
        return $reagents;
    } else {
        logMessage('LINE 42: Item not found');
    }
}

function insertReagents($reagents, $id_item, $conn){
    foreach($reagents as $reagent){
        $name = $conn->real_escape_string($reagent['name']);
        $quantity = $reagent['quantity'];
        $sql = "SELECT id_item FROM items WHERE name = '" . $name . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_reagent = $row['id_item'];
            $sql = "SELECT * FROM architecture WHERE id_item = $id_item AND id_reagent = $id_reagent";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                logMessage("LINE 58: ARQ record already exists");
            } else {
                $sql = "INSERT INTO architecture (id_item, id_reagent, quantity) VALUES ($id_item, $id_reagent, $quantity)";
                if ($conn->query($sql) === TRUE) {
                    logMessage("LINE 62: New ARQ record created successfully");
                } else {
                    logMessage("LINE 64: Error: " . $sql . " - " . $conn->error);
                }
            }
         
        } else {
            $sql = "INSERT INTO items (name) VALUES ('" . $name . "')";
            if ($conn->query($sql) === TRUE) {
                logMessage("LINE 71: NEW ITEM CREATED: $name");
                $id_reagent = $conn->insert_id;
                $sql = "INSERT INTO architecture (id_item, id_reagent, quantity) VALUES ($id_item, $id_reagent, $quantity)";
                if ($conn->query($sql) === TRUE) {
                    logMessage("LINE 75: New ARQ record created successfully");
                } else {
                    logMessage("Error: " . $sql . " - " . $conn->error);
                }
            }
        }
    }
}
$items = [];
$sql = "SELECT id_item, name FROM items where type = 2";
$result = $conn->query($sql);
foreach ($result as $row) {
    $items[$row['id_item']] = $row['name'];
}
foreach($items as $id_item => $name){ 
    $reagents = getReagents($name);
    insertReagents($reagents, $id_item, $conn);

}
$conn->close();
echo '###END###';
?>

