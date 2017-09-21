<?php
/**
 * 
 * 数据模型企业资质证书
 * @author 吴枫
 */
class CertificateModel extends SystemModel{
    
    /**
     * 根据品牌进行分组
     * @return type 分组集合
     */
    public function getCertificateGroupBy($pagenum,$rowsnum){
        $join = "LEFT JOIN __BRAND__ AS tb ON tb.id=a.brand_id";
        $field ="tb.id,tb.name";
        $data = $this->alias("a")->field($field)->join($join)->group("a.brand_id")->limit(($pagenum-1)*$rowsnum.','.$rowsnum)->select();
        return $data;
    }
    /**
     * 统计个数
     * @return type 总记录数
     */
    public function getCertificateCount(){
         $join = "LEFT JOIN __BRAND__ AS tb ON tb.id=a.brand_id";
         $data = $this->alias("a")->join($join)->group("a.brand_id")->select();
         return count($data);
    }

    // 添加
    public function addCertificate($value){
        return $this->add($value);
    }

    // 删除
    public function deleteCert($brand_id){ 
        return $this->where(array('brand_id' => array("IN", $brand_id)))->delete();
    }

    // 删除2
    public function deleteCertificate($id){
        return $this->where(array('id' => array("IN", $id)))->delete();
    }

    //获取证书
    public function getCertificateByGid($con){
        $data = $this->field('id,certificate_name')->where(array('brand_id' => $con['brand_id']))->select();
        $list = M('certificate_list')->where($con)->select();
            foreach ($data as $key => $value) {
                $data[$key]["flag"] = "";
                foreach ($list as $key1 => $value1) {
                    if($list[$key1]["certificate_id"]==$data[$key]["id"]){
                        $data[$key]["flag"] = "checked";
                    }
                }
            }
        return $data;
    }

}
?>
