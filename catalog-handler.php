<?php

$output = [
    'products' => [],
    'pafinationInfo' => [
        'nowPage' => 1,
        'countPage' => 5
    ]
];

$link = mysqli_connect('localhost','root','','29092018_2_3project');
mysqli_set_charset($link,'utf8');

$limit = 4;
$page = 1;

if (isset($_GET['page'])){
    $page = $_GET['page'];
}
$from_num = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(id) as len FROM products";
$result_count = mysqli_query($link,$sql_count);
$count_row = mysqli_fetch_assoc($result_count)['len'];
$count_page = ceil($count_row/$limit);

$output['pafinationInfo']['nowPage'] = $page;
$output['pafinationInfo']['countPage'] = $count_page;

$sql = "SELECT*FROM products limit $from_num, $limit";
$result = mysqli_query($link,$sql);

while($row = mysqli_fetch_assoc($result)){
    $output['products'][] = $row;
}





echo json_encode($output);