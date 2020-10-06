<?php
namespace Qualification\Form;

use Laminas\Form\Form;

class QualificationForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('qualification');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'qualificationDescription',
            'type' => 'text',
            'options' => [
                'label' => 'Description of the qualification',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submit button',
            ],
        ]);
    }
}