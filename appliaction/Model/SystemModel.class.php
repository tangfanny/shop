<?php 
/**
 *      到货通知
 */
class SystemModel extends Model {
	
	public function detail($id, $field = TRUE) {
		$id = (int) $id;
		if($id < 1) {
			$this->error = '参数错误';
			return false;
		}
		$row = $this->field($field)->find($id);
		if(!$row) {
			$this->error = '您查看的记录不存在';
			return false;
		}
		return $row;
	}
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