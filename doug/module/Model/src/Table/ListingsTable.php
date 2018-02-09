<?php
namespace Model\Table;

use DateTime;
use DateInterval;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class ListingsTable extends TableGateway
{
    const TABLE_NAME = 'listings';
    public function findByCategory($category)
    {
        return $this->select(['category' => $category]);
    }
    public function findById($id)
    {
        return $this->select(['listings_id' => $id])->current();
    }
    public function findLatest()
    {
        $select = (new Sql($this->getAdapter()))->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id desc')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
    public function save($data)
    {
        //*** FILE UPLOADS LAB: you will need to check the 'photo_filename' field
        //***                   if it does not contain "http://" or "https://" you will
        //***                   need prepend "images/<CATEGORY>" to the uploaded filename.
        //***                   Have a look at the "listings" table to see how it works
        $data['date_expires'] = $this->getDateExpires($data['expires']);
        [$data['city'], $data['country']] = explode(',', $data['cityCode']);
        unset($data['expires']);
        unset($data['submit']);
        unset($data['cityCode']);
        unset($data['captcha']);
        unset($data['csrf']);
        return $this->insert($data);
    }
    protected function getDateExpires($expires)
    {
        $now = new DateTime();
        $now = ($expires) ? $now->add(new DateInterval('P' . (int) $expires . 'D')) : $now;
        return $now->format('Y-m-d H:i:s');
    }
}
