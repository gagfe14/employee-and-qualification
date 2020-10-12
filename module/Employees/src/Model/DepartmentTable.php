<?php
namespace Employees\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class DepartmentTable
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

    public function getDepartment($id)
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

    public function saveDepartment(Department $department)
    {
        $data = [
            'departmentName' => $department->departmentName,
            'departmentDescription'  => $department->departmentDescription,
        ];

        $id = (int) $department->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getDepartment($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update course with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteDepartment($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>