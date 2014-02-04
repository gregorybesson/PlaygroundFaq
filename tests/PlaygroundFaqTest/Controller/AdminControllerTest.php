<?php

namespace PlaygroundFaqTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PlaygroundFaq\Entity\Faq;
use PlaygroundFaqTest\Bootstrap;

class AdminControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        parent::setUp();

        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php'
        );
    }

    public function testListAction()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);

        $faqService = $this->getMockBuilder('PlaygroundFaq\Service\Faq')
        ->setMethods(array('getAllFaqs'))
        ->disableOriginalConstructor()
        ->getMock();

        $serviceManager->setService('playgroundfaq_faq_service', $faqService);

        $faqService->expects($this->once())
        ->method('getAllFaqs')
        ->will($this->returnValue(array()));

        $response = $this->dispatch('/admin/faq/list');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('playgroundfaq');
        $this->assertControllerClass('AdminController');
        $this->assertActionName('list');
    }

    public function testRemoveAction()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);

        $faqService = $this->getMockBuilder('PlaygroundFaq\Service\Faq')
        ->setMethods(array('remove'))
        ->disableOriginalConstructor()
        ->getMock();

        $faqMapper = $this->getMockBuilder('PlaygroundFaq\Mapper\Faq')
        ->setMethods(array('findById'))
        ->disableOriginalConstructor()
        ->getMock();

        $faqService->setFaqMapper($faqMapper);
        $serviceManager->setService('playgroundfaq_faq_service', $faqService);
        $serviceManager->setService('playgroundfaq_faq_mapper', $faqMapper);

        $faq = new Faq();
        $faq->setQuestion('qq')
        ->setAnswer('aa')
        ->setIsActive(1)
        ->setPosition(1);

        $faqMapper->expects($this->once())
        ->method('findById')
        ->will($this->returnValue($faq));

        $faqService->expects($this->once())
        ->method('remove');

        $response = $this->dispatch('/admin/faq/remove/1');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('playgroundfaq');
        $this->assertControllerClass('AdminController');
        $this->assertActionName('remove');
        $this->assertRedirectTo('/admin/faq/list');
    }
}
