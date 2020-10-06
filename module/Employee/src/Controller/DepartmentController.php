<?php
namespace Department\Controller;
use Department\Form\DepartmentForm;
use Department\Model\Department;
use Department\Model\DepartmentTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class DepartmentController extends AbstractActionController
{

    private $table;
    //
    public function __construct(DepartmentTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
        return new ViewModel([
            'departments' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
		$form = new DepartmentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $department = new Department();
        $form->setInputFilter($department->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $department->exchangeArray($form->getData());
        $this->table->saveDepartment($department);
        return $this->redirect()->toRoute('department');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('department', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $department = $this->table->getDepartment($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('department', ['action' => 'index']);
        }

        $form = new DepartmentForm();
        $form->bind($department);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($department>getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveDepartment($department);

        // Redirect to employee list
        return $this->redirect()->toRoute('department', ['action' => 'index']);
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('department');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteDepartment($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('department');
    }
		return [
            'id'    => $id,
            'department' => $this->table->getDepartment($id),
        ];
    }
}