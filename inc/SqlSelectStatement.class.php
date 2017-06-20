<?php
class SqlSelectStatement
{
	private $_sqlStatement;

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
		if(!empty($where))
        {
            foreach($where as $field => $value)
            {
                $value = $value;
                $clause[] = "$field = '$value'";
            }
            $this->_sqlStatement .= " WHERE ". implode(' AND ', $clause);
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