<?php

namespace PlaygroundFaq\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PlaygroundFaq\Options\ModuleOptions;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
    protected $options, $faqMapper, $adminFaqService;

    public function listAction()
    {
        $faqs = $this->getAdminFaqService()->getAllFaqs();

        if (is_array($faqs)) {
            $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($faqs));
        } else {
            $paginator = $faqs;
        }

        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));

        return array(
            'faqs' => $paginator,
        );
    }

    public function createAction()
    {
        $form = $this->getServiceLocator()->get('playgroundfaq_faq_form');
        $form->setAttribute('action', $this->url()->fromRoute('admin/playgroundfaq_admin/create', array('faqId' => 0)));
        $form->setAttribute('method', 'post');

        $faq = new \PlaygroundFaq\Entity\Faq();
        $form->bind($faq);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $faq = $this->getAdminFaqService()->create($data, $faq);
            if ($faq) {
                $this->flashMessenger()->setNamespace('playgroundfaq')->addMessage('La FAQ a été créée');

                return $this->redirect()->toRoute('admin/playgroundfaq_admin/list');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setTemplate('playground-faq/admin/faq');

        return $viewModel->setVariables(array('form' => $form));
    }

    public function editAction()
    {
        $faqId = $this->getEvent()->getRouteMatch()->getParam('faqId');
        $faq = $this->getFaqMapper()->findById($faqId);
        $form = $this->getServiceLocator()->get('playgroundfaq_faq_form');
        $form->setAttribute('action', $this->url()->fromRoute('admin/playgroundfaq_admin/edit', array('faqId' => $faqId)));
        $form->setAttribute('method', 'post');

        $form->bind($faq);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $faq = $this->getAdminFaqService()->edit($data, $faq);
            if ($faq) {
                $this->flashMessenger()->setNamespace('playgroundfaq')->addMessage('La FAQ a été créée');

                return $this->redirect()->toRoute('admin/playgroundfaq_admin/list');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setTemplate('playground-faq/admin/faq');

        return $viewModel->setVariables(array('form' => $form));
    }

    public function removeAction()
    {
        $faqId = $this->getEvent()->getRouteMatch()->getParam('faqId');
        $faq = $this->getFaqMapper()->findById($faqId);
        if ($faq) {
            $this->getAdminFaqService()->remove($faq);
            $this->flashMessenger()->setNamespace('playgroundfaq')->addMessage('FAQ supprimée');
        }

        return $this->redirect()->toRoute('admin/playgroundfaq_admin/list');
    }

    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('playgroundfaq_module_options'));
        }

        return $this->options;
    }

    public function getFaqMapper()
    {
        if (null === $this->faqMapper) {
            $this->faqMapper = $this->getServiceLocator()->get('playgroundfaq_faq_mapper');
        }

        return $this->faqMapper;
    }

    public function setFaqMapper(FaqMapperInterface $faqMapper)
    {
        $this->faqMapper = $faqMapper;

        return $this;
    }

    public function getAdminFaqService()
    {
        if (null === $this->adminFaqService) {
            $this->adminFaqService = $this->getServiceLocator()->get('playgroundfaq_faq_service');
        }

        return $this->adminFaqService;
    }

    public function setAdminFaqService($service)
    {
        $this->adminFaqService = $service;

        return $this;
    }
}
