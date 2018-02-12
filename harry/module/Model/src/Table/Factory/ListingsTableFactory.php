<?php
namespace Model\Table\Factory;

use Model\Table\ListingsTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListingsTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ListingsTable(ListingsTable::TABLE_NAME, $container->get('model-primary-adapter'));
    }
}
