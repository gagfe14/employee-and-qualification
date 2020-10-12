<?php      
namespace Employees\Model;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class Employee implements InputFilterAwareInterface
{
    public $id;
    public $lastName;
    public $firstName;
    public $departmentId;
    public $qualification;
   
	private $inputFilter;
	
    public function exchangeArray(array $data)
    {
        $this->id   = isset($data['id']) ? $data['id'] : null;
        $this->lastName = isset($data['lastName']) ? $data['lastName'] : null;
        $this->firstName   = isset($data['firstName']) ? $data['firstName'] : null;
        $this->departmentId = isset($data['departmentId']) ? $data['departmentId'] : null;
        $this->qualification   = isset($data['qualification']) ? $data['qualification'] : null;
       
    }
	
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'lastName' => $this->lastName,
            'firstName'  => $this->firstName,
            'departmentId' => $this->departmentId,
            'qualification'  => $this->qualification,
        ];
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'lastName',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'firstName',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'departmentId',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'qualification',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
	}
}
?>