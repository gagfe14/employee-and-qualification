<?php
namespace Department;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\DepartmentTable::class => function($container) {
                    $tableGateway = $container->get(Model\DepartmentTableGateway::class);
                    return new Model\DepartmentTable($tableGateway);
                },
                Model\DepartmentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Department());
                    return new TableGateway('department', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    // Add this method:
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\DepartmentController::class => function($container) {
                    return new Controller\DepartmentController(
                        $container->get(Model\DepartmentTable::class)
                    );
                },
            ],
        ];
    }

}

?>