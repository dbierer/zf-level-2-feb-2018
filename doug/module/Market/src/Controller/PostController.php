<?php
namespace Market\Controller;

use Market\Form\UploadTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

//*** add correct "use" statements
use Market\Listener\CacheAggregate;

class PostController extends AbstractActionController
{

    const ERROR_POST = 'ERROR: unable to validate item information';
    const ERROR_SAVE = 'ERROR: unable to save item to the database';
    const SUCCESS_POST = 'SUCCESS: item posted OK';
    const EVENT_POST = 'market.post.event';

    use FlashTrait;
    use PostFormTrait;
    use ListingsTableTrait;
    use CityCodesTableTrait;
    use UploadTrait;

    public function indexAction()
    {
        $data = [];
        if ($this->getRequest()->isPost()) {
            //*** FILE UPLOAD LAB: combine $_POST with $_FILES
            $data = $this->params()->fromPost();
            $this->breakoutCityAndCountry($data);
            //*** FILE UPLOAD LAB: append "category" to upload rename filter
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                //*** FILE UPLOAD LAB: move uploaded file from /images folder into /images/<category>
                //*** FILE UPLOAD LAB: reset $data['photo_filename'] to final filename /images/<category>/filename
                $goodData = $this->postForm->getData();
                if ($this->listingsTable->save($goodData)) {
                    $this->flash->addMessage(self::SUCCESS_POST);
                    //*** EVENTMANAGER LAB: trigger a log event and pass the online market item title as a parameter
                    $em = $this->getEventManager();
                    $em->addIdentifiers([__CLASS__]);
                    $em->trigger(self::EVENT_POST, $this, ['title' => $goodData['title']]);
                    //*** CACHE LAB: trigger event which signals clear cache
                    $cacheKey = 'market_view_category_' . $data['category'];
                    $em->trigger(CacheAggregate::EVENT_CLEAR_CACHE, $this, ['cacheKey' => $cacheKey]);
                    return $this->redirect()->toRoute('market');
                } else {
                    $this->flash->addMessage(self::ERROR_SAVE);
                }
            } else {
                $this->flash->addMessage(self::ERROR_POST);
            }
        }
        return new ViewModel(['postForm' => $this->postForm, 'data' => $data, 'flash' => $this->flash]);
    }

    public function lookupAction()
    {
        $city = $this->params()->fromQuery('id');
        var_dump($_GET);
        exit;
    }

    protected function breakoutCityAndCountry(&$data)
    {
        if (isset($data['cityCode']) && strpos($data['cityCode'], ','))
            list($data['city'],$data['country']) = explode(',', $data['cityCode']);
    }
}
