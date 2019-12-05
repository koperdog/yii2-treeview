<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-treeview/blob/master/LICENSE
 */

namespace koperdog\yii2treeview\base;

use yii\base\Model;

/**
 * Helper class preparing models for finding, building a tree
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0.0
 */
class TreeHelper {
    /*
     * @var TreeView the tree view object that owns this helper
     */
    private $grid;
    
    /**
     * TreeView object owner helper
     * 
     * @param \koperdog\yii2treeview\TreeView $context
     */
    public function __construct(\koperdog\yii2treeview\TreeView $context)
    {
        $this->grid = $context;
    }
    
    /**
     * Prepares an array of models
     * 
     * depending on the filterModel, if a filter is applied, it will return a simple array of models; 
     * if the filter is empty, it will build a Tree of models
     * 
     * @param array $models
     * @return array 
     */
    public function prepareModels(array $models): array
    {        
        if( $this->grid->filterModel instanceof Model && (bool)array_filter($this->grid->filterModel->attributes)){
            return $models;
        }
        
        return $this->asTree($models);
    }
    
    /**
     * Builds tree of models
     * 
     * @param array $models
     * @return array
     */
    public function asTree(array $models): array
    {
        $tree = [];

        foreach ($models as $n) {
            $node = &$tree;

            for ($depth = $models[0]->depth; $n->depth > $depth; $depth++) {
                $node = &$node[count($node) - 1]->children;
            }
            $n->children = null;
            $node[] = $n;
        }
        return $tree;
    }
}
