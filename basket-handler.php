<?php
    session_start();


    $output = [
        'basketInfo' => [
            'count' => 0,
            'fullPrice' => 0
        ]
    ];

    if ( isset( $_GET['product_id'] ) ){                                            // проверяем передается ли параметр id 
        $product_id = $_GET['product_id'];                                          // создаем переменную product_id из url

        if ( !isset( $_SESSION['basket'] ) ){                                       // проверяем существует ли массив $_SESSION['basket']
            $_SESSION['basket']=  [                                                 // 
                'products' => []                                                    // если нет, создаем его
            ];                                                                      //
        }else{
            $is_find = false;                                                       // создаем флажок 
            foreach ( $_SESSION['basket']['products'] as $key => $product_item ){   // перебираем массив $_SESSION['basket']['products'] и ищем товар
                if( $product_item['id'] == $product_id ){                           // проверяем есть ли элемент с '$product_id' таким Id
                    $_SESSION['basket']['products'][$key]['count']++;               // добавляем к 'count' 1 единицу товара, т.к. такой товар уже есть в корзине
                    $is_find = true;                                                // переводим флажок в состояние true
                    break;
                }
            }
            if( !$is_find ){                                                        // т.к. такого товара в корзине нет создаем его

                $link = mysqli_connect('localhost','root','','29092018_2_3project');// идем в бд и получаем данные
                mysqli_set_charset($link,'utf8');
                $sql = " SELECT price FROM products WHERE id = {$product_id} ";
                $result = mysqli_query($link, $sql);
                $price = mysqli_fetch_assoc($result)['price'];


                $_SESSION['basket']['products'][] = [                               // добавление товара в корзину
                    'id' => $product_id,
                    'price' => $price,
                    'count' => 1
                ];
            }
        }
        // echo "<pre>";
        // print_r( $_SESSION['basket'] );                                          // проверка вывода
        // echo "</pre>";

    }

    if ( isset($_SESSION['basket']) ){
        foreach( $_SESSION['basket']['products'] as $product_item ){
            $output['basketInfo']['count'] += $product_item['count'];
            $output['basketInfo']['fullPrice'] += $product_item['count'] * $product_item['price'];
        }
    }


    echo json_encode( $output );