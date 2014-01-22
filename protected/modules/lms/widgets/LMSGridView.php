<?php

namespace Rendes\Widgets;

\Yii::import('application.widgets.TbJsonGridView');

class LMSGridView extends \TbJsonGridView
{

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if($this->columns===array())
        {
            if($this->dataProvider instanceof \CActiveDataProvider)
                $this->columns=$this->dataProvider->model->attributeNames();
            elseif($this->dataProvider instanceof \IDataProvider)
            {
                // use the keys of the first row of data as the default columns
                $data=$this->dataProvider->getData();
                if(isset($data[0]) && is_array($data[0]))
                    $this->columns=array_keys($data[0]);
            }
        }
        $id=$this->getId();
        foreach($this->columns as $i=>$column)
        {
            if(is_string($column))
                $column=$this->createDataColumn($column);
            else
            {
                if(!isset($column['class']))
                    $column['class']='TbJsonDataColumn';
                $column=\Yii::createComponent($column, $this);
            }
            if(!$column->visible)
            {
                unset($this->columns[$i]);
                continue;
            }
            if($column->id===null)
                $column->id=$id.'_c'.$i;
            $this->columns[$i]=$column;
        }

        foreach($this->columns as $column)
            $column->init();
    }
}