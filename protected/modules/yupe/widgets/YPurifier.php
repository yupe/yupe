<?php
namespace yupe\widgets;

use CHtmlPurifier;

class YPurifier extends CHtmlPurifier
{
    public function __construct($owner = null)
    {
        parent::__construct($owner);

        $params = [
            'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            'HTML.SafeIframe' => true,
            'CSS.Trusted' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/|rutube.ru\/play\/embed)%',
        ];

        return $this->setOptions($params);
    }
}