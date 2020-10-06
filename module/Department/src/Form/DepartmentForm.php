<?php
namespace Department\Form;

use Laminas\Form\Form;

class DepartmentForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('department');

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
                'label' => 'Department Description',
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