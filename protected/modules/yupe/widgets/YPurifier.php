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
        ];

        return $this->setOptions($params);
    }
}