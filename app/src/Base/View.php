<?php


namespace Koj\Base;


class View
{
    /**
     * @param $template
     * @param array $data
     * @param bool $return
     * @return string|void
     */
    public static function render($template, array $data = array(), bool $return = false)
    {
        $template = TEMPLATES_PATH . '/' . $template;
        $template .= preg_match('~\\.php$~i', $template) ? '' : '.php';

        if(!is_file($template))
            static::showError('Template ' . $template . ' is not found');

        empty($data) || extract($data, EXTR_REFS);

        ob_start();
        include $template;
        $content = ob_get_clean();

        if($return)
            return $content;
        echo $content;
    }

    /**
     * @param string $message
     */
    public static function showError($message = 'Error: Page Not Found')
    {
        static::render('site/404', compact('message'));
        exit;
    }
}