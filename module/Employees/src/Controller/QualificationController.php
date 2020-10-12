<?php
namespace Employees\Controller;
use Employees\Form\QualificationForm;
use Employees\Model\Qualification;
use Employees\Model\QualificationTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class QualificationController extends AbstractActionController
{

    private $table;
    //
    public function __construct(QualificationTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'qualifications' => $this->table->fetchAll(),
        ]);
    }
    public function addAction()
    {
		$form = new QualificationForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $qualification = new Qualification();
        $form->setInputFilter($qualification->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $qualification->exchangeArray($form->getData());
        $this->table->saveQualification($qualification);
        return $this->redirect()->toRoute('qualification');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('qualification', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $qualification = $this->table->getQualification($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('qualification', ['action' => 'index']);
        }

        $form = new QualificationForm();
        $form->bind($qualification);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($qualification->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveQualification($qualification);

        // Redirect to album list
        return $this->redirect()->toRoute('qualification', ['action' => 'index']);
    }

    public function deleteAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('qualification');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteQualification($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('qualification');
    }
		return [
            'id'    => $id,
            'qualification' => $this->table->getQualification($id),
        ];
    }
}