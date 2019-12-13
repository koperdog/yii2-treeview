# TreeView widget
Widget to display the nested sets tree as a grid

Based on [GridView](https://www.yiiframework.com/doc/api/2.0/yii-grid-gridview)

![Packagist](https://img.shields.io/packagist/dt/koperdog/yii2-treeview) ![Packagist Version](https://img.shields.io/packagist/v/koperdog/yii2-treeview) ![PHP from Packagist](https://img.shields.io/packagist/php-v/koperdog/yii2-treeview)

![preview](https://user-images.githubusercontent.com/15054192/70629631-1d20c300-1c4c-11ea-854b-19aaa64137fb.png)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist koperdog/yii2-treeview "*"
```

or add

```
"koperdog/yii2-treeview": "*"
```

to the require section of your `composer.json` file.

## Usage

Add to your model field:
```php
public $children = null;
```

### Has the same settings as GridView.
Models in dataProvider must be sorted by tree and lft

```php
echo koperdog\yii2treeview\TreeView::widget([
	'dataProvider'  => $dataProvider,
	//'depthPrefix' => ' — ', //see Additional options
	//'depthRoot'   => 1, //see Additional options
	//'collaplse'   => true, //see Additional options
	'columns' => [
	  'id',
	  'name',
	  'created_at:datetime',
	  // ...
	],
    ]);
```

if you don't have column attribute name or title, for display depth use:
```php
'columns' => [
...
[
    // your attribute options
    'value' =>  function($model, $index, $key){
    	return str_repeat(' — ', $model->depth).$model->attribute;
    }
],
...
```

### The column classes the same as GridView
```php
['class' => '\koperdog\yii2treeview\base\CheckboxColumn'],
['class' => '\koperdog\yii2treeview\base\ActionColumn'],
['class' => '\koperdog\yii2treeview\base\RadioButtonColumn'],
['class' => '\koperdog\yii2treeview\base\SerialColumn'],
```

<details>
  <summary>Additional options</summary>
	
##### depthPrefix - Prefix that displays depth (default " — ")
##### depthRoot - Offset from the root (default 0)
##### collaplse - if true, it will add the class "closed" to the node elements, and "tree-collapse" to the root of the tree (default false)

</details>
