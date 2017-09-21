<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MysqlModel extends Model {
    protected $connection = 'DB_CONFIG2';
    
    /* 添加&更新记录 */
    public function update($data, $iscreate = TRUE) {
		if ($iscreate == TRUE) $data = $this->create($data);
		if (empty($data)) {
			$this->error = $this->getError();
			return false;
		}
		if (isset($data[$this->fields['_pk']]) && is_numeric($data[$this->fields['_pk']]) && $data[$this->fields['_pk']] > 0) {
			$result = $this->save($data);
			if (!$result) {
				$this->error = '更新数据失败';
				return false;
			}
		} else {
			$result = $this->add($data);
			if ($result === false) {
				$this->error = '添加数据失败';
				return false;
			}
		}
		return $result;
	}
    
}
?>
