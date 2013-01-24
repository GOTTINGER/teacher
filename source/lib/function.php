<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function markdown_parse($content)
{
    require_once AppFile::lib('markdown' . DS . 'markdown');
    return Markdown(parse_inner_link($content));
}

function parse_inner_link($str)
{
    return preg_replace('/\[(.+?)\](?!\()/', '[$1]($1)', $str);
}

function diff($from, $to)
{
    $from = mb_convert_encoding($from, 'HTML-ENTITIES', 'UTF-8');
    $to = mb_convert_encoding($to, 'HTML-ENTITIES', 'UTF-8');

    require_once AppFile::lib('finediff');
    $diff = new FineDiff($from, $to, FineDiff::$paragraphGranularity);
    $html = $diff->renderDiffToHTML();

    $html = mb_convert_encoding($html, 'UTF-8', 'HTML-ENTITIES');
    $html = html_entity_decode($html);
    $html = nl2br($html);

    return $html;
}
