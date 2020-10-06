<?php

namespace Employee;

use Employee\Controller\EmployeeController;
use Laminas\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'employee' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/employee[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => EmployeeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

                'department' => [
                    'type'    => Segment::class,
                    'options' => [
                        'route' => '/department[/:action[/:id]]',
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                        ],
                        'defaults' => [
                            'controller' => DepartmentController::class,
                            'action'     => 'index',
                        ],
                    ],
                ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'employee' => __DIR__ . '/../view',
            'department' => __DIR__ . '/../view',
        ],
    ],
];

?>