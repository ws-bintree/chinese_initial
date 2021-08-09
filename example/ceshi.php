<?php
/**
 * Created by PhpStorm.
 * User: Fyj
 * Date: 2020/1/7 15:14
 */
require '../src/chineseInitial.php';

$arr =[
    ['name'=>'小龙虾','num'=>44],
    ['name'=>'大螃蟹','num'=>66],
    ['name'=>'母鸡','num'=>22],
    ['name'=>'板鸭','num'=>33],
    ['name'=>'清水鱼','num'=>41],
    ['name'=>'茄子','num'=>13]
];
$new_arr = (new chineseInitial\getInitial)->groupByInitials($arr);
print_r($new_arr);
$new_arr = (new chineseInitial\getInitial)->getInitial('ww');
print_r($new_arr);
