<?php
$path = "D:/信息/大学/大四/2021-2022 第二学年/毕业档案电子档/18网络工程3班/";    //此处可以使用变量名组成的字符串来动态创建文件
$names = [
    "陈强",
    "陈士雨",
    "程千雨",
    "崔云辉",
    "杜思雨",
    "付川宁",
    "贡见祥",
    "侯伦武",
    "胡高明",
    "胡凌濒",
    "胡用庆",
    "黄冰倩",
    "姜安升",
    "蒋斗艳",
    "李宁",
    "李张萌",
    "刘馨茹",
    "卢贤伟",
    "彭海洋",
    "钱志远",
    "施婉婷",
    "舒怡",
    "孙进鹏",
    "汤娟",
    "汪峰",
    "汪佩霖",
    "汪锶锶",
    "王千伟",
    "王志勇",
    "吴俊",
    "徐升进",
    "杨文旭",
    "余弦",
    "俞志鹏",
    "张诚",
    "张路",
    "周诚",
    "周铨",
    "朱陈妍",
    "祝骁",
    "董晟鹏",
    "刘帅",
];


foreach ($names as $name) {
    $fileName = $path . $name;
    // 没有就创建一个新文件夹
    if (!mkdir($fileName, 0777, true) && !is_dir($fileName)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $fileName));
    }

}

