<?php
namespace Qualification;

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
                Model\QualificationTable::class => function($container) {
                    $tableGateway = $container->get(Model\QualificationTableGateway::class);
                    return new Model\QualificationTable($tableGateway);
                },
                Model\QualificationTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Qualification());
                    return new TableGateway('qualification', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    // Add this method:
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\QualificationController::class => function($container) {
                    return new Controller\QualificationController(
                        $container->get(Model\QualificationTable::class)
                    );
                },
            ],
        ];
    }

}

?>