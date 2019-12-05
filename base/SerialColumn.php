<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace koperdog\yii2treeview\base;

/**
 * SerialColumn displays a column of row numbers (1-based).
 *
 * To add a SerialColumn to the [[TreeView]], add it to the [[TreeView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     [
 *         'class' => 'koperdog\yii2treeview\base\SerialColumn',
 *     ],
 * ]
 * ```
 *
 * Based on [[yii\grid\SerialColumn]]
 * Cloned to change namespace and add property - $attribute
 * 
 * @author Koperdog <koperdog@gmail.com>
 * @version 1.0.0
 */
class SerialColumn extends Column
{
    /**
     * @var string default name for column class
     */
    public $attribute = '_serial';
    
    /**
     * {@inheritdoc}
     */
    public $header = '#';


    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $pagination = $this->grid->dataProvider->getPagination();
        if ($pagination !== false) {
            return $pagination->getOffset() + $index + 1;
        }

        return $index + 1;
    }
}
