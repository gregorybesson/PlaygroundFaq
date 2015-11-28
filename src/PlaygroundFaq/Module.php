<?php

namespace PlaygroundFaq;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $options = $serviceManager->get('playgroundcore_module_options');
        $locale = $options->getLocale();
        $translator = $serviceManager->get('translator');
        if (!empty($locale)) {
            //translator
            $translator->setLocale($locale);

            // plugins
            $translate = $serviceManager->get('viewhelpermanager')->get('translate');
            $translate->getTranslator()->setLocale($locale);
        }
        AbstractValidator::setDefaultTranslator($translator, 'playgroundcore');
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'playgroundfaq_doctrine_em' => 'doctrine.entitymanager.orm_default',
            ),

            'invokables' => array(
                'playgroundfaq_faq_service' => 'PlaygroundFaq\Service\Faq',
            ),

            'factories' => array(
                'playgroundfaq_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');

                    return new Options\ModuleOptions(isset($config['playgroundfaq']) ? $config['playgroundfaq'] : array());
                },
                'playgroundfaq_faq_mapper' => function ($sm) {
                    return new \PlaygroundFaq\Mapper\Faq(
                        $sm->get('playgroundfaq_doctrine_em'),
                        $sm->get('playgroundfaq_module_options')
                    );
                },
                'playgroundfaq_faq_form' => function ($sm) {
                    $translator = $sm->get('translator');
                    $options = $sm->get('playgroundfaq_module_options');
                    $form = new Form\Faq(null, $translator);
                    $faq = new Entity\Faq();
                    $form->setInputFilter($faq->getInputFilter());

                    return $form;
                },
            ),
        );
    }
}
