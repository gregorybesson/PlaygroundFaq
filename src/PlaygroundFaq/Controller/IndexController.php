<?php

namespace PlaygroundFaq\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $options, $faqService;

    public function indexAction()
    {

        $faqs = $this->getFaqService()->getActiveFaqs();
        if (is_array($faqs)) {
            $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($faqs));
        } else {
            $paginator = $faqs;
        }

        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));

        return new ViewModel(array('faqs' => $paginator));
    }

    public function getFaqService()
    {
        if (!$this->faqService) {
            $this->faqService = $this->getServiceLocator()->get('playgroundfaq_faq_service');
        }

        return $this->faqService;
    }

    public function setFaqService(FaqService $faqService)
    {
        $this->faqService = $faqService;

        return $this;
    }
}
