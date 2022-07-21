<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 商品图册构体
 */
class ProductAlbum extends \Qyweixin\Model\Base
{
    /**
     * product_id	是	商品id
     */
    public $product_id = NULL;

    /**
     * description	是	商品的名称、特色等;不超过300个字
     */
    public $description = NULL;

    /**
     * price	是	商品的价格，单位为分；最大不超过5万元
     */
    public $price = NULL;

    /**
     * product_sn	否	商品编码；不超过128个字节；只能输入数字和字母
     */
    public $product_sn = NULL;

    /**
     * attachments	是	附件类型，仅支持image，最多不超过9个附件
     * @var array(\Qyweixin\Model\ExternalContact\ProductAlbum\Attachment\Image)
     */
    public $attachments = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_id)) {
            $params['product_id'] = $this->product_id;
        }

        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->price)) {
            $params['price'] = $this->price;
        }
        if ($this->isNotNull($this->product_sn)) {
            $params['product_sn'] = $this->product_sn;
        }
        if ($this->isNotNull($this->attachments)) {
            foreach ($this->attachments as  $attachment) {
                $params['attachments'][] = $attachment->getParams();
            }
        }
        return $params;
    }
}
