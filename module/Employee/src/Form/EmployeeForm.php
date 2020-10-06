<?php
namespace Employee\Form;

use Laminas\Form\Form;

class EmployeeForm extends Form
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
            'name' => 'lastName',
            'type' => 'text',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);
        $this->add([
            'name' => 'firstName',
            'type' => 'text',
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'name' => 'departmentId',
            'type' => 'text',
            'options' => [
                'label' => 'Department Id',
            ],
        ]);

        $this->add([
            'name' => 'qualification',
            'type' => 'text',
            'options' => [
                'label' => 'Qualification',
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