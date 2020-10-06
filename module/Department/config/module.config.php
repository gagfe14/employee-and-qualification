<?php

namespace Department;

use Department\Controller\DepartmentController;
use Laminas\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
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
            'department' => __DIR__ . '/../view',
        ],
    ],
];

?>