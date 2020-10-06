<?php

namespace Qualification;

use Qualification\Controller\EmployeeController;
use Laminas\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'qualification' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/qualification[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => QualificationController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'qualification' => __DIR__ . '/../view',
        ],
    ],
];

?>