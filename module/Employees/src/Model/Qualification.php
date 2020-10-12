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
use Laminas\Filter\ToFloat;
class Qualification implements InputFilterAwareInterface
{
    public $id;
    public $qualificationType;
    public $qualificationDescription;
    private $inputFilter;
	
    public function exchangeArray(array $data)
    {
        $this->id   = isset($data['id']) ? $data['id'] : null;
        $this->qualificationType = isset($data['qualificationType']) ? $data['qualificationType'] : null;
        $this->qualificationDescription   = isset($data['qualificationDescription']) ? $data['qualificationDescription'] : null;

    }
	
	 public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'qualificationType' => $this->qualificationType,
            'qualificationDescription' => $this->qualificationDescription,
            
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
            'name' => 'qualificationType',
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
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'qualificationDescription',
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
                        'max' => 100,
                    ],
                ],
            ],
        ]);


        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
	}
}
?>