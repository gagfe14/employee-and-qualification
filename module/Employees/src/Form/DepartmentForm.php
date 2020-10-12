<?php
namespace Employees\Form;

use Laminas\Form\Form;

class DepartmentForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('employee');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'departmentName',
            'type' => 'text',
            'options' => [
                'label' => 'Department Name',
            ],
        ]);
        $this->add([
            'name' => 'departmentDescription',
            'type' => 'text',
            'options' => [
                'label' => 'Department description',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}