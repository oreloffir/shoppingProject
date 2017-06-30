<?php
class SqlSelectStatement
{
	private $_sqlStatement;
    private $whereSet = false;

	public function __construct($sqlStart)
	{
		$this->_sqlStatement = $sqlStart;
	}

	public function addToBody($addition = '')
	{
		$this->_sqlStatement .= " ".$addition;
		return $this;
	}

	public function addSelectFields($fieldsArr)
	{
		foreach($fieldsArr as $tableName => &$fields)
		{
			foreach($fields as &$field)
			{
				$field = $tableName.'.'.$field;
			}
			$fields = implode(', ', $fields);
		}
		$this->_sqlStatement .= " ".implode(', ', $fieldsArr);
		return $this;
	}

	public function addTableName($tableName)
	{
		$this->_sqlStatement .= " FROM ".$tableName;
		return $this;
	}
	public function addWhere($where = array())
	{
        $clause = array();
		if(!empty($where))
        {
            foreach($where as $field => $value)
            {
                if(is_array($value)){
                    $clause[] = "$field IN (".implode(', ', $value).")";
                }else {
                    $clause[] = "$field = '$value'";
                }
            }
            if(!$this->whereSet)
                $this->_sqlStatement .= " WHERE ". implode(' AND ', $clause);
            else
                $this->_sqlStatement .= " AND ". implode(' AND ', $clause);

            $this->whereSet = true;
        }
        return $this;
	}

	public function addLike($like = array()){
        $clause = array();
        if(!empty($like))
        {
            foreach($like as $field => $value)
                $clause[] = "$field LIKE '%$value%'";

            if(!$this->whereSet)
                $this->_sqlStatement .= " WHERE ". implode(' AND ', $clause);
            else
                $this->_sqlStatement .= " AND ". implode(' AND ', $clause);
            $this->whereSet = true;
        }
        return $this;
    }

	public function addOrderBy($orders)
	{
		if(!empty($orders))
		{
			foreach($orders as $order => $orderBy)
				$orderArr[] = "$order $orderBy";
			$this->_sqlStatement .= " ORDER BY ".implode(', ', $orderArr);
		}
        return $this;
	}

	public function addLimit($start = '', $count = '')
	{
		if($start != '')
            if($count != '')
                $this->_sqlStatement .= " LIMIT ".$start.",".$count;
            else
                $this->_sqlStatement .= " LIMIT ". $start;
        return $this;
	}

	public function getSqlStatement()
	{
		return $this->_sqlStatement;
	}
}

?>