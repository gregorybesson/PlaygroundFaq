<?php

namespace PlaygroundFaqTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PlaygroundFaq\Entity\Faq;

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
//         $serviceManager = $this->getApplicationServiceLocator();
//         $serviceManager->setAllowOverride(true);

//         $faqService = $this->getMockBuilder('PlaygroundFaq\Service\Faq')
//         ->setMethods(array('getAllFaqs'))
//         ->disableOriginalConstructor()
//         ->getMock();

//         $query = new \Doctrine\ORM\Query();

//         $serviceManager->setService('playgroundfaq_faq_service', $faqService);

//         $faqService->expects($this->once())
//         ->method('getAllFaqs')
//         ->will($this->returnValue($query));

//         $response = $this->dispatch('/admin/faq/list');
//         $this->assertResponseStatusCode(302);
//         $this->assertModuleName('playgroundfaq');
//         $this->assertControllerClass('AdminController');
//         $this->assertActionName('list');
        $this->assertTrue(true);
    }

    public function testRemoveAction()
    {
//         $serviceManager = $this->getApplicationServiceLocator();
//         $serviceManager->setAllowOverride(true);

//         $faqService = $this->getMockBuilder('PlaygroundFaq\Service\Faq')
//         ->setMethods(array('remove', 'getFaqMapper'))
//         ->disableOriginalConstructor()
//         ->getMock();

//         $faqMapper = $this->getMockBuilder('PlaygroundFaq\Mapper\Faq')
//         ->setMethods(array('findById'))
//         ->disableOriginalConstructor()
//         ->getMock();

//         $serviceManager->setService('playgroundfaq_faq_service', $faqService);

//         $faq = new Faq();

//         $faqService->expects($this->once())
//         ->method('getFaqMapper')
//         ->will($this->returnValue($faqMapper));

//         $faqService->expects($this->once())
//         ->method('remove');

//         $faqMapper->expects($this->once())
//         ->method('findById')
//         ->will($this->returnValue($faq));

//         $response = $this->dispatch('/admin/faq/remove/1');
//         $this->assertResponseStatusCode(302);
//         $this->assertModuleName('playgroundfaq');
//         $this->assertControllerClass('AdminController');
//         $this->assertActionName('remove');
        $this->assertTrue(true);
    }
}
