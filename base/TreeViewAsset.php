<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace koperdog\yii2treeview\base;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the [[TreeView]] widget.
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class TreeViewAsset extends AssetBundle
{
    public $sourcePath = '@vendor/koperdog/yii2-treeview/assets';
    
    public $css = [
        'css/treeview.css',
    ];
    
    public $depends = [
        'yii\grid\GridViewAsset',
    ];
}
