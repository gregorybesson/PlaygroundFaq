<?php

namespace PlaygroundFaqTest\Service;

use PlaygroundFaqTest\Bootstrap;
use \PlaygroundFaq\Entity\Faq as FaqEntity;
use PlaygroundFaq\Entity\Faq;

class FaqTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $faqMapper;

    protected $faqService;

    public function setUp()
    {
        $this->sm = Bootstrap::getServiceManager();
        $this->em = $this->sm->get('doctrine.entitymanager.orm_default');
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
        $classes = $this->em->getMetadataFactory()->getAllMetadata();
        $tool->dropSchema($classes);
        $tool->createSchema($classes);
        parent::setUp();
    }

    public function testCreateFalse()
    {
        $sm =  Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $service = $sm->get('playgroundfaq_faq_service');

        $form = $this->getMockBuilder('PlaygroundFaq\Form\Faq')
            ->setMethods(array('setHydrator', 'bind', 'setData', 'isValid'))
            ->disableOriginalConstructor()
            ->getMock();

        $sm->setService('playgroundfaq_faq_form', $form);

        $form->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->assertFalse($service->create(array("title" => "hello"), new FaqEntity));

    }

    public function testCreateTrue()
    {
        $sm =  Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $service = $sm->get('playgroundfaq_faq_service');

        $responseTest = true;

        $mapper = $this->getMockBuilder('PlaygroundFaq\Mapper\Faq')
            ->disableOriginalConstructor()
            ->getMock();

        $sm->setService('playgroundfaq_faq_mapper', $mapper);

        $mapper->expects($this->any())
            ->method('insert')
            ->will($this->returnValue($responseTest));

        $form = $this->getMockBuilder('PlaygroundFaq\Form\Faq')
            ->setMethods(array('setHydrator', 'bind', 'setData', 'isValid'))
            ->disableOriginalConstructor()
            ->getMock();

        $sm->setService('playgroundfaq_faq_form', $form);

        $form->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->assertEquals($responseTest, $service->create(array("title" => "hello"), new FaqEntity));

    }

    public function testEditFalse()
    {
        $sm =  Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $service = $sm->get('playgroundfaq_faq_service');

        $form = $this->getMockBuilder('PlaygroundFaq\Form\Faq')
            ->setMethods(array('setHydrator', 'bind', 'setData', 'isValid'))
            ->disableOriginalConstructor()
            ->getMock();

        $sm->setService('playgroundfaq_faq_form', $form);

        $form->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->assertFalse($service->edit(array("title" => "hello"), new FaqEntity));

    }

    public function testEditTrue()
    {
        $sm =  Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $service = $sm->get('playgroundfaq_faq_service');

        $responseTest = true;

        $mapper = $this->getMockBuilder('PlaygroundFaq\Mapper\Faq')
            ->setMethods(array('update'))
            ->disableOriginalConstructor()
            ->getMock();

        $mapper->expects($this->any())
            ->method('update')
            ->will($this->returnValue($responseTest));

        $form = $this->getMockBuilder('PlaygroundFaq\Form\Faq')
            ->setMethods(array('setHydrator', 'bind', 'setData', 'isValid'))
            ->disableOriginalConstructor()
            ->getMock();

        $sm->setService('playgroundfaq_faq_form', $form);

        $service->setFaqMapper($mapper);

        $form->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->assertEquals($responseTest, $service->edit(array("title" => "hello"), new FaqEntity));

    }

    public function testRemove()
    {
        $sm =  Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $service = $sm->get('playgroundfaq_faq_service');

        $responseTest = true;

        $mapper = $this->getMockBuilder('PlaygroundFaq\Mapper\Faq')
            ->disableOriginalConstructor()
            ->getMock();

        $mapper->expects($this->any())
            ->method('remove')
            ->will($this->returnValue($responseTest));

        $service->setFaqMapper($mapper);

        $this->assertEquals($responseTest, $service->remove(new FaqEntity));
    }

    public function tearDown()
    {
        $dbh = $this->em->getConnection();
        unset($this->sm);
        unset($this->em);
        parent::tearDown();
    }


}
