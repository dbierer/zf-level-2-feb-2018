<?php
namespace Market\Delegators;

use Zend\Form\Element\Csrf;
use Interop\Container\ContainerInterface;

class AddCsrf
{
    public function __invoke(ContainerInterface $container,$name,callable $callback,array $options = null)
    {
        $form = $callback();    
        $form->add(new Csrf('csrf'));
        return $form;
    }
}
