<?php
    session_start();
    $output = [
        'basketInfo'=>[
            'count'=> 0,
            'fullPrice'=> 0
        ]
    ];
    // Добавление товара в корзину
    if( isset( $_GET['product_id'] ) ){
        $product_id = $_GET['product_id'];

        if( !isset( $_SESSION['basket'] ) ){
            $_SESSION['basket'] = [
                'products'=>[]
            ];   
        }

        $is_find = false;
        foreach( $_SESSION['basket']['products'] as $key=> $product_item){
            if( $product_item['id'] == $product_id ){
                $_SESSION['basket']['products'][$key]['count']++;
                $is_find = true;
                break;
            }
        }

        if( !$is_find ){
            $link = mysqli_connect('localhost', 'root', '', '29092018_2_3project');
            mysqli_set_charset($link, 'utf8');

            $sql = "SELECT price FROM products WHERE id = {$product_id}";
            $result = mysqli_query($link, $sql);
            $price = mysqli_fetch_assoc($result)['price'];

            $_SESSION['basket']['products'][] = [
                'id'=> $product_id,
                'price'=> $price,
                'count'=> 1
            ];   
        }

        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";

    }

    // $_SESSION['basket']=[
    //     'products'=>[
    //         [
    //             'id'=>1,
    //             'price'=>1990,
    //             'count'=>4
    //         ],
    //         [
    //             'id'=>12,
    //             'price'=>2990,
    //             'count'=>1
    //         ],
    //     ]
    // ];

    //Подсчет характеристик корзины
    if( isset( $_SESSION['basket'] ) ){
        foreach( $_SESSION['basket']['products'] as $product_item ){
            $output['basketInfo']['count'] +=$product_item['count']; 
            $output['basketInfo']['fullPrice'] +=  
                $product_item['count'] * $product_item['price']; 
        }
    }

    echo json_encode( $output );