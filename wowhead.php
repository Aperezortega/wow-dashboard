<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');
include('db.php');
ini_set('display_errors', 1);

function getName($id){
    $baseUrl = 'https://www.wowhead.com/cata/item=';
    $searchUrl = $baseUrl . $id;
    $html = file_get_html($searchUrl);
    $titleNode = $html->find('title', 0);
    $title = $titleNode->innertext; // Obtén el texto dentro del nodo
    $name = explode('-', $title)[0];
    return $name;
}
function getReagents($item){
    $reagents = [];
    $baseUrl = 'https://www.wowhead.com/cata/search?q=';
    $parseItem = str_replace(' ', '+', $item);
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
            echo $reagent[0] . '=>' . $reagent[1] . "<br>";
            $reagents[] = [
                'name' => getName($itemId),
                'quantity' => $quantity,
            ];
        }
        return $reagents;
    } else {
        echo 'Item not found';
        }
    }

function insertReagents($reagents, $id_item){
        foreach($reagents as $reagent){
            $name = $reagent['name'];
            $quantity = $reagent['quantity'];
            $sql = "SELECT id_item FROM items WHERE name = '" . $name . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_item = $row['id_item'];
                $sql = "INSERT INTO architecture (id_item, id_reagent, quantity) VALUES ($id_item, $id_reagent, $quantity)";
                if ($conn->query($sql) === TRUE) {
                    echo "New ARQ record created successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $sql = "INSERT INTO items (name) VALUES ('" . $name . "')";
                if ($conn->query($sql) === TRUE) {
                    $id_item = $conn->insert_id;
                    $sql = "INSERT INTO architecture (id_item, id_reagent, quantity) VALUES ($id_item, $id_reagent, $quantity)";
                    if ($conn->query($sql) === TRUE) {
                        echo "New ARQ record created successfully <br>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            
        }
    }
}
$items = [];
$sql = "SELECT id_item, name FROM items limit 10";
$result = $conn->query($sql);
foreach ($result as $row) {
    $items[$row['id_item']] = $row['name'];
}
foreach($items as $id_item => $name){ 
    $reagents = getReagents($item);
    insertReagents($reagents, $id_item);


    
}
?>

