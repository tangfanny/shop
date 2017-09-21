<?php
/**
 *
 * Yu Wei
 * 2016年4月23日
 */

class AuthCertificateModel extends MysqlModel
{

    /**
     * 查询售前证书图片
     * @param int $aid
     * @return mixed
     */
    function getAdvisorCertifcate($aid)
    {
        return $this->field('certificate')->where('type=1 and uid='.$aid)->select();
    }

    /**
     * 查询商品的证书图片
     */
    function getGoodsCertifcate($goods_id)
    {
        return $this->field('certificate')->where('type=2 and goods_id='.$goods_id)->select();
    }
}