<?php
include('db.php');
function bom_strip($str) {
    return preg_replace('/^\xEF\xBB\xBF/', '', $str);
}
function insertHerb($id_herb, $id_pigment, $conn){
    $sql = "SELECT * FROM architecture WHERE id_item =$id_pigment  AND id_reagent = $id_herb";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo " LINE 58: ARQ record already exists <br>";
    } else {
        $sql = "INSERT INTO architecture (id_item, id_reagent, quantity) VALUES ($id_pigment, $id_herb, 5)";
        if ($conn->query($sql) === TRUE) {
            echo " LINE 62: New ARQ record created successfully <br>";
        } else {
            echo " LINE 64: Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
function cleanString($str) {
    // Remove BOM and non-breaking spaces
    $str = preg_replace('/^\xEF\xBB\xBF/', '', $str);
    $str = str_replace("\xc2\xa0", ' ', $str);
    // Trim standard whitespace
    $str = trim($str);
    return $str;
}
function getIdItem($name, $conn){
    $name = trim($name);
    $name = $conn->real_escape_string($name);
    $sql = "SELECT id_item FROM items WHERE name = '".$name."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $id_item = $row['id_item'];
        return $id_item;
    } else {
        $sql = "INSERT INTO items (name) VALUES ('".$name."')";
        if ($conn->query($sql) === TRUE) {
            $id_item = $conn->insert_id;
            return $id_item;
        }
    }    
}

$handle = fopen('herbs.csv', 'r');
if ($handle !== false) {
    while (($line = fgets($handle)) !== false) {
        $line = bom_strip($line);
        $line = str_replace(', ',',', $line);
        $row = explode(';', trim($line));
        $pigment = trim($row[0], '"');
        $herbs = trim($row[1], '"');
        $herbs = explode(',', $herbs);
        $pigments = explode(',', $pigment);
        foreach($pigments as $pigment){
            $pigment = cleanString($pigment);
            $id_pigment = getIdItem($pigment, $conn);
            foreach($herbs as $herb){
                $herb = cleanString($herb);
                $id_herb =  getIdItem($herb, $conn);
                insertHerb($id_herb, $id_pigment, $conn);
            }
        }
    }
}
echo '###END###';
// Cerrar el archivo CSV
fclose($handle);
?>