<?php

include 'vendor/autoload.php';

use duongdat\phpSimple\HtmlDomParser;

if (isset($_GET["url"])) {
    $url = $_GET["url"];
    $content = getContent($url);
    $html = HtmlDomParser::str_get_html($content);
    $links = $html->find('.list-wrap p span a');
    $arr_link = [];
    foreach ($links as $key => $result) {
        $link['chapter_num'] = count($links) - $key;
        $link['chapter_link'] = 'https://blogtruyen.vn' . $result->href;
        $link['chapter_img'] = getImgChapter('https://blogtruyen.vn' . $result->href);
        array_push($arr_link, $link);
    }
    header('Content-Type: application/json');
    echo json_encode($arr_link);
}else {
    echo 'Example: <a href="/index.php?url=https://blogtruyen.vn/25610/kekkon-surutte-hontou-desu-ka">' . $_SERVER['HTTP_HOST'] . '/index.php?url=https://blogtruyen.vn/25610/kekkon-surutte-hontou-desu-ka'.'</a>';
}

function getContent($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getImgChapter($url)
{
    $content = getContent($url);
    $html = HtmlDomParser::str_get_html($content);
    $images = $html->find('article img');
    $img = [];
    foreach ($images as $result) {
        $img[] = $result->src;
    }
    return $img;
}
