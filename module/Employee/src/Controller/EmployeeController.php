<?php
namespace Employee\Controller;
use Employee\Form\EmployeeForm;
use Employee\Model\Employee;
use Employee\Model\EmployeeTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class EmployeeController extends AbstractActionController
{

    private $table;
    //
    public function __construct(EmployeeTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel([
            'employees' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
		$form = new EmployeeForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $employee = new Employee();
        $form->setInputFilter($employee->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $employee->exchangeArray($form->getData());
        $this->table->saveEmployee($employee);
        return $this->redirect()->toRoute('employee');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('employee', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $employee = $this->table->getEmployee($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('employee', ['action' => 'index']);
        }

        $form = new EmployeeForm();
        $form->bind($employee);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($employee->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveEmployee($employee);

        // Redirect to album list
        return $this->redirect()->toRoute('employee', ['action' => 'index']);
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('employee');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteEmployee($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('employee');
    }
		return [
            'id'    => $id,
            'employee' => $this->table->getEmployee($id),
        ];
    }
}