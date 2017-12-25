<?php

namespace ff\grid\components;

use yii\bootstrap\ButtonDropdown;
use yii\widgets\LinkPager as LinkPagerBaseYii;

class LinkPager extends LinkPagerBaseYii
{
    /**
     * Кол-во выводимых строк
     * @var array
     */
    private $pageSizeList = [20, 50, 100, 500];

    /**
     * @var string
     */
    public $layout = '{pageSizeList}{pageButtons}';

    /**
     * @var array
     * @see \yii\widgets\LinkPager::$options
     */
    public $options = ['class' => 'pagination btn-group'];

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$prevPageLabel
     */
    public $prevPageLabel = '<<';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$nextPageLabel
     */
    public $nextPageLabel = '>>';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$firstPageLabel
     */
    public $firstPageLabel = 'First';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$lastPageLabel
     */
    public $lastPageLabel = 'Last';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$nextPageCssClass
     */
    public $nextPageCssClass = 'next';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$prevPageCssClass
     */
    public $prevPageCssClass = 'prev';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$firstPageCssClass
     */
    public $firstPageCssClass = 'first';

    /**
     * @var string
     * @see \yii\widgets\LinkPager::$lastPageCssClass
     */
    public $lastPageCssClass = 'last';

    /**
     * @var int
     * @see \yii\widgets\LinkPager::$maxButtonCount
     */
    public $maxButtonCount = 1;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pageSizeList = array_unique($this->pageSizeList);
        sort($this->pageSizeList, SORT_NUMERIC);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        $placeholderValues = [
            '{pageSizeList}' => $this->renderPageSizeList(),
            '{pageButtons}' => $this->renderPageButtons(),
        ];

        echo strtr($this->layout, $placeholderValues);
    }

    /**
     * @return string
     */
    private function renderPageSizeList()
    {
        if ($this->pagination->totalCount < $this->pagination->pageSize && $this->pagination->pageSize <= min($this->pageSizeList)) {
            return '';
        }

        $element = array_map(function ($value) {
            return [
                'label' => $value,
                'url' => $this->pagination->createUrl($this->pagination->getPage(), $value)
            ];
        }, $this->pageSizeList);

        return ButtonDropdown::widget([
            'label' => $this->pagination->pageSize,
            'dropdown' => [
                'items' => $element,
            ],
            'options' => [
                'class' => 'btn-default',
                'tag' => 'span',

            ],
            'containerOptions' => ['class' => 'pagination']
        ]);
    }
}