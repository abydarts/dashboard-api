<?php
/**
 * Banner
 * @package banner
 * @version 0.1.0
 */

namespace Banner\Library;

use Banner\Model\Banner as _Banner;

class Banner
{
    private static $banners;

    private static function getTemplate(int $type, array $templates): string
    {
        $type_texts = [
            1 => 'image',
            2 => 'html',
            3 => 'gads',
            4 => 'iframe'
        ];

        $type_text = $type_texts[$type];

        $tmpl_default = [
            'image' => [
                '<a href="(:link)" target="_blank" title="(:title)">',
                    '<img src="(:url)" alt="(:title)">',
                '</a>'
            ],
            'html' => '(:html)',
            'gads' => '(:code)',
            'iframe' => '<iframe src="(url)"></iframe>'
        ];

        $template = $tmpl_default[$type_text];
        if (isset($templates[$type_text]))
            $template = $templates[$type_text];

        if (is_array($template))
            $template = implode(PHP_EOL, $template);
        return $template;
    }

    private static function loadBanners(): void
    {
        if (!is_null(self::$banners))
            return;

        self::$banners = [];

        $banners = _Banner::get([
            'expires' => ['__op', '>', date('Y-m-d H:i:s')]
        ]);

        if (!$banners)
            return;

        foreach($banners as $banner) {
            if (!isset(self::$banners[$banner->placement]))
                self::$banners[$banner->placement] = [];
            $banner->content = json_decode($banner->content);
            self::$banners[$banner->placement][] = $banner;
        }
    }

    public static function renderBanner(object $banner, array $templates): string
    {
        $template = self::getTemplate($banner->type, $templates);
        $content  = $banner->content;

        foreach($content as $key => $value)
            $template = str_replace('(:' . $key . ')', $value, $template);

        return $template;
    }

    public static function put(string $placement, array $templates): void
    {
        self::loadBanners();

        $banners = self::$banners[$placement] ?? [];

        // 0 show from db only
        // 1 show from db and placeholder
        // 2 show placeholder only
        // 3 show nothing
        $show = \Mim::$app->req->getQuery('friend', '0');
        if ($show == 3)
            return;

        if($show == 2)
            $banners = [];

        if (in_array($show, ['1','2'])){
            $placeholder = $templates['placeholder'] ?? [];
            if($placeholder) {
                $count = $placeholder['count'];
                for($i=0; $i<$count; $i++){
                    $banners[] = (object)[
                        'type' => 1,
                        'content' => (object)$placeholder
                    ];
                }
            }
        }

        if(!$banners)
            return;

        $result = [];
        foreach($banners as $banner) {
            $result[] = self::renderBanner($banner, $templates);
        }

        echo implode('', $result);
    }
}
