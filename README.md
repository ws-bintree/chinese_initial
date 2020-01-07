汉语首字母提取
=============

实在是没找到汉语首字母分类的好点的办法，自己想点子写了个
## 安装(Install)



```
composer require bingchao/chineseInitial
```
或者
```
require '../src/chineseInitial.php';
```

##使用(use)

```$xslt
$new_arr = (new chineseInitial\getInitial)->groupByInitials($arr);
```

```$xslt
$arr =[
	['name'=>'小龙虾','num'=>44],
	['name'=>'大螃蟹','num'=>66],
	['name'=>'母鸡','num'=>22],
	['name'=>'板鸭','num'=>33],
	['name'=>'清水鱼','num'=>41],
	['name'=>'茄子','num'=>13]
];
```

```$xslt
$new_arr = Array
           (
               [B] => Array
                   (
                       [0] => Array
                           (
                               [name] => 板鸭
                               [num] => 33
                               [initials] => B
                           )
                   )
               [D] => Array
                   (
                       [0] => Array
                           (
                               [name] => 大螃蟹
                               [num] => 66
                               [initials] => D
                           )
                   )
               [M] => Array
                   (
                       [0] => Array
                           (
                               [name] => 母鸡
                               [num] => 22
                               [initials] => M
                           )
                   )
               [Q] => Array
                   (
                       [0] => Array
                           (
                               [name] => 清水鱼
                               [num] => 41
                               [initials] => Q
                           )
                       [1] => Array
                           (
                               [name] => 茄子
                               [num] => 13
                               [initials] => Q
                           )
                   )
               [X] => Array
                   (
                       [0] => Array
                           (
                               [name] => 小龙虾
                               [num] => 44
                               [initials] => X
                           )
                   )
           )

```


可能会存在多音字的查询错误，如示例的茄子就以jia优先了，可自行更改pinyin.txt文件的顺序