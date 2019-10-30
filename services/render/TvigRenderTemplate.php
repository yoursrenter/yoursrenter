<?php

namespace App\services\render;

class TvigRenderTemplate
{
    public static function Render($params)
    {
        extract($params);
        $tmpl = $params['mainTemplate'] . '/' . $params['contentTemplate'];
        $content = TvigRenderTemplate::RenderTemplate(
            $tmpl,
            $params);
        $params['content'] = $content;
        return TvigRenderTemplate::RenderTemplate(
            $params['mainTemplate'], $params);
    }

    public static function RenderTemplate($template, $params)
    {
        ob_start();
        extract($params);
        include $_SERVER['DOCUMENT_ROOT'] . '/views/' . $template . '.php';
        return ob_get_clean();
    }
}