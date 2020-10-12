<?php
namespace Employees\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class QualificationTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getQualification($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) { 
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveQualification(Qualification $qualification)
    {
        $data = [
            'qualificationType' => $qualification->qualificationType,
            'qualificationDescription' => $qualification->qualificationDescription,
            
        ];

        $id = (int) $qualification->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getJposition($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update position with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteQualification($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>