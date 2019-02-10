<?php

    session_start();

    if ( isset( $_SESSION['basket'] ) ){

        $link = mysqli_connect('localhost','root','','29092018_2_3project');
        mysqli_set_charset($link,'utf8');

        foreach( $_SESSION['basket']['products'] as $product_item ){
            $product_id = $product_item['id'];
            
            $sql = " SELECT * FROM products WHERE id = {$product_id} ";

        };
        $result = mysqli_query($link, $sql);
        $card = [];
        while( $row = mysqli_fetch_assoc($result) ){
            $card[] = $row;
        };
        
    }else{
        echo "<h2>Ваша корзина пуста</h2>";
    };


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/catalog-style.css">
    <title>Вaша корзина</title>
</head>
<body>
    <div class="catalog">
        <div class="catalog-products">
            <?php
            
            // foreach( $card as $item ){
            //     echo "<img src='/images/catalog/{$item['photo']}'>
            //     <div class='name'>{$item['name']}</div>
            //     <div class='price'>{$item['price']} руб.</div>";
            // };
            
            echo "<pre>";
            print_r( $card );                                          
            echo "</pre>";


            ?>
        </div>
    </div>

    

</body>
</html>