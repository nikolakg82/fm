<?php

namespace fm\lib\publisher;


class QueryBuilder
{
    protected $query;

    protected $select = '*';

    protected $from;

    protected $where = array();

    protected $limit;

    protected $order;

    public function where($strField, $strValue, $strOperator = '=')
    {
        $this->where[] = array(
            'field'     => $strField,
            'value'     => $strValue,
            'operator'  => $strOperator
            );
    }

    public function select($strSelect)
    {
        $this->select = $strSelect;
    }
}