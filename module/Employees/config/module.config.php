<?php

namespace Employees;


use Laminas\Router\Http\Segment;


return [
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'employee' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/employees/employee[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\EmployeeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'department' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/employees/department[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DepartmentController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'qualification' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/employees/qualification[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\QualificationController::class,
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
            'qualification' => __DIR__ . '/../view',
            
        ],
    ],
];

?>