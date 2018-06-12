<?php

namespace PlaygroundFaq\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;
use Zend\Stdlib\Hydrator\ClassMethods;
use PlaygroundFaq\Options\ModuleOptions;

class Faq extends EventProvider implements ServiceManagerAwareInterface
{

    /**
     * @var FaqMapperInterface
     */
    protected $faqMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var FaqServiceOptionsInterface
     */
    protected $options;

    public function create(array $data, $faq)
    {
        $form  = $this->getServiceManager()->get('playgroundfaq_faq_form');
        $form->setHydrator(new ClassMethods());
        $form->bind($faq);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }

        return $this->getFaqMapper()->insert($faq);
    }

    public function edit(array $data, $faq)
    {
        $form  = $this->getServiceManager()->get('playgroundfaq_faq_form');
        $form->setHydrator(new ClassMethods());
        $form->bind($faq);
        $form->setData($data);
        if (!$form->isValid()) {
            return false;
        }
        return $this->getFaqMapper()->update($faq);

    }

    public function remove($faq)
    {
        return $this->getFaqMapper()->remove($faq);

    }

    /**
     * getActiveFaqs
     *
     * @return Array of PlaygroundFaq\Entity\Faq
     */
    public function getActiveFaqs()
    {
        $em = $this->getServiceManager()->get('playgroundfaq_doctrine_em');

        $query = $em->createQuery('SELECT f FROM PlaygroundFaq\Entity\Faq f WHERE f.isActive = true ORDER BY f.position ASC');
        $faqs = $query->getResult();

        return $faqs;
    }

    /**
     * getAllFaqs
     *
     * @return Array of PlaygroundFaq\Entity\Faq
     */
    public function getAllFaqs()
    {
        $em = $this->getServiceManager()->get('playgroundfaq_doctrine_em');

        $query = $em->createQuery('SELECT f FROM PlaygroundFaq\Entity\Faq f ORDER BY f.position ASC');
        $faqs = $query->getResult();

        return $faqs;
    }

    /**
     * getFaqMapper
     *
     * @return FaqMapperInterface
     */
    public function getFaqMapper()
    {
        if (null === $this->faqMapper) {
            $this->faqMapper = $this->getServiceManager()->get('playgroundfaq_faq_mapper');
        }

        return $this->faqMapper;
    }

    /**
     * setFaqMapper
     *
     * @param  FaqMapperInterface $faqMapper
     * @return Faq
     */
    public function setFaqMapper($faqMapper)
    {
        $this->faqMapper = $faqMapper;

        return $this;
    }

    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceManager()->get('playgroundfaq_module_options'));
        }

        return $this->options;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param  ServiceManager $locator
     * @return Action
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }
}
