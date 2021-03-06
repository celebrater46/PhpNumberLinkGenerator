<?php

require_once "NumberLink.php";

$max_text_num = 5; // 1ページに表示するテキストの最大数
$max_link_num = 5; // 1ページに貼る数字リンクの最大数

$file_names = glob('files/*.txt'); // ファイル名一覧
$link = new NumberLink($max_text_num, $max_link_num, count($file_names));

$titles = create_titles($link->text_sum);
$texts = get_texts($file_names);


function create_titles($sum){
    $array = [];
    for($i = 0; $i < $sum; $i++){
        array_push($array, "sample title " . ($i + 1));
    }
    return $array;
}

function get_texts($names){
    $texts = [];
    for ($i = 0; $i < count($names); $i++){
        array_push($texts, file($names[$i]));
    }
    return $texts;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="copyright" content="Enin Fujimi">
    <title>PHP Number Link Generator</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <p><?php echo "page_num: " . $link->page_num ; ?></p>
    <p><?php echo "current_link_page: " . $link->current_link_page ; ?></p>
    <p><?php echo "start_page_num: " . $link->start_page_num ; ?></p>

    <h1>PHP Number Link Generator</h1>
    <?php for ($i = $link->start; $i < $link->start + $max_text_num; $i++) : ?>
        <?php if($i < $link->text_sum) : ?>
            <hr>
            <h2><?php echo $titles[$i]; ?></h2>
            <div>
                <?php foreach ($texts[$i] as $line) : ?>
                    <p><?php echo $line; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endfor; ?>

    <p class="links">
        <?php if($link->current_link_page > 1) : ?>
            <a href="index.php?page=<?php echo ($link->current_link_page - 1) * $max_link_num; ?>">
                <<
            </a>
        <?php endif; ?>

        <?php for($i = $link->start_page_num; $i <= $link->current_link_page * $max_link_num; $i++) : ?>
            <?php if($i <= $link->page_num) : ?>
                <a href="index.php?page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if($link->page_num > $link->current_link_page * $max_link_num) : ?>
            <a href="index.php?page=<?php echo $link->current_link_page * $max_link_num + 1; ?>">
                >>
            </a>
        <?php endif; ?>
    </p>
</body>
</html>
