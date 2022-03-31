<?php
function tagToHtml($tags, $label_class = 'label-default')
{
    $out = explode(',', $tags);
    $html = '';
    foreach ($out as $item) {
        $html .= '<span class="label ' . $label_class . '">' . trim($item) . '</span> ';
    }
    return $html;
}

function descriptionMaker($txt, $length = 30)
{
    $txt = strip_tags($txt);
    $pch = explode(' ', $txt);
    $out = '';
    for ($i = 0; $i < $length; $i++) {
        if (isset($pch[$i])) {
            $out .= $pch[$i] . ' ';
        }
    }

    if (count($pch) > $length) {
        $out .= '...';
    }

    return $out;
}

function random_color()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

function csvCell($input)
{
    $input = str_replace("\"", "\\\"", $input);
    // $input = str_replace(",", "\\,", $input);
    // $input = str_replace(";", "\\;", $input);
    return '"' . $input . '"';
}
