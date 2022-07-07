<?php

namespace Porygon\Base\Admin\Grid\Displayers;

use Dcat\Admin\Grid\Displayers\DialogTree as DisplayersDialogTree;


class DialogTree extends DisplayersDialogTree
{
    public function setValue($value)
    {
        return $this->value = $value;
    }
}
