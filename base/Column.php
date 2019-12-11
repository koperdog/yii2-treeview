<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace koperdog\yii2treeview\base;

use Closure;
use yii\base\BaseObject;
use yii\helpers\Html;

/**
 * Column is the base class of all [[TreeView]] column classes.
 *
 * For more details and usage information on Column, see the [guide article on data widgets](guide:output-data-widgets).
 * Based on [[yii\grid\Column]]
 *  
 * @author Koperdog <koperdog.dev@gmail.com>
 * @version 1.0.0
 */
class Column extends BaseObject
{
    /**
     * @var GridView the grid view object that owns this column.
     */
    public $grid;
    /**
     * @var string the header cell content. Note that it will not be HTML-encoded.
     */
    public $header;
    /**
     * @var string the footer cell content. Note that it will not be HTML-encoded.
     */
    public $footer;
    /**
     * @var callable This is a callable that will be used to generate the content of each cell.
     * The signature of the function should be the following: `function ($model, $key, $index, $column)`.
     * Where `$model`, `$key`, and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[Column]] object.
     */
    public $content;
    /**
     * @var bool whether this column is visible. Defaults to true.
     */
    public $visible = true;
    /**
     * @var array the HTML attributes for the column group tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array the HTML attributes for the header cell tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array|\Closure the HTML attributes for the data cell tag. This can either be an array of
     * attributes or an anonymous function ([[Closure]]) that returns such an array.
     * The signature of the function should be the following: `function ($model, $key, $index, $column)`.
     * Where `$model`, `$key`, and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[Column]] object.
     * A function may be used to assign different attributes to different rows based on the data in that row.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $contentOptions = [];
    /**
     * @var array the HTML attributes for the footer cell tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];
    /**
     * @var array the HTML attributes for the filter cell tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $filterOptions = [];


    /**
     * Renders the header cell.
     */
    public function renderHeaderCell()
    {
        $column_name = str_replace('.', '_', $this->getAttribute());
        $this->headerOptions['class'] = $this->headerOptions['class']? $this->headerOptions['class'].' '.$column_name : $column_name;
        
        return Html::tag('div', $this->renderHeaderCellContent(), $this->headerOptions);
    }

    /**
     * Renders the footer cell.
     */
    public function renderFooterCell()
    {
        $column_name = str_replace('.', '_', $this->getAttribute());
        $this->footerOptions['class'] = $this->footerOptions['class']? $this->footerOptions['class'].' '.$column_name : $column_name;
        
        return Html::tag('div', $this->renderFooterCellContent(), $this->footerOptions);
    }

    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    public function renderDataCell($model, $key, $index)
    {
        if ($this->contentOptions instanceof Closure) {
            $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
        } else {
            $options = $this->contentOptions;
        }
        
        $column_name = str_replace('.', '_', $this->getAttribute());
        $options['class'] = $options['class']? $options['class'].' '.$column_name : $column_name;
        
        return Html::tag('div', $this->renderDataCellContent($model, $key, $index), $options);
    }

    /**
     * Renders the filter cell.
     */
    public function renderFilterCell()
    {
        $column_name = str_replace('.', '_', $this->getAttribute());
        $this->filterOptions['class'] = $this->filterOptions['class']? $this->filterOptions['class'].' '.$column_name : $column_name;
        return Html::tag('div', $this->renderFilterCellContent(), $this->filterOptions);
    }

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    protected function renderHeaderCellContent()
    {
        return trim($this->header) !== '' ? $this->header : $this->getHeaderCellLabel();
    }

    /**
     * Returns header cell label.
     * This method may be overridden to customize the label of the header cell.
     * @return string label
     * @since 2.0.8
     */
    protected function getHeaderCellLabel()
    {
        return $this->grid->emptyCell;
    }

    /**
     * Renders the footer cell content.
     * The default implementation simply renders [[footer]].
     * This method may be overridden to customize the rendering of the footer cell.
     * @return string the rendering result
     */
    protected function renderFooterCellContent()
    {
        return trim($this->footer) !== '' ? $this->footer : $this->grid->emptyCell;
    }

    /**
     * Renders the data cell content.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content !== null) {
            return call_user_func($this->content, $model, $key, $index, $this);
        }

        return $this->grid->emptyCell;
    }

    /**
     * Renders the filter cell content.
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     * @return string the rendering result
     */
    protected function renderFilterCellContent()
    {
        return $this->grid->emptyCell;
    }
    
    /**
     * Gets the attrbiute name or label of the column
     * If column have not name and label, then generates base on the column class name
     * 
     * @return string
     */
    protected function getAttribute(): string
    {
        if($this->attribute){
            return $this->attribute;
        }
        else if($this->label){
            return $this->label;
        }
        
        $className = strtolower(get_called_class());
        
        return str_replace('column', '', $className);
    }
}
