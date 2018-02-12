<?php
namespace Market;

use Zend\Mvc\MvcEvent;

class Module
{
    //*** EVENTMANAGER SHARED MANAGER LAB: add a listener to the "log" event which records the title of the item posted
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectCategories']);
        $shared = $eventManager->getSharedManager();
        $shared->attach(PostController::class,
            PostController::EVENT_POST,
            function($e) {
            $title = $e->getParam('title');
            error_log($title);
        },
        100);
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function injectCategories(MvcEvent $e)
    {
        $viewModel = $e->getViewModel();
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel->setVariable('categories', $serviceManager->get('categories'));
    }
    public function getServiceConfig()
    {
        return [
            //*** DELEGATORS LAB
            //*** Create a new service which returns a "Zend\Form\Element\Csrf" element
            //*** Create a delegator factory
            //*** Add a "delegators" key which points the form creation to the delegator
            //*** Have the delegator add the "Csrf" to the form as a hidden form element
        ];
    }
}
