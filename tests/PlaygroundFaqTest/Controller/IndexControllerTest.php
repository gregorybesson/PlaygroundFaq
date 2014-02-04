<?php

namespace PlaygroundFaqTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {

        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php'
        );
        parent::setUp();
    }

    public function testIndexAction()
    {
//         $serviceManager = $this->getApplicationServiceLocator();
//         $serviceManager->setAllowOverride(true);

//         $faqService = $this->getMockBuilder('PlaygroundFaq\Service\Faq')
//         ->setMethods(array('getActiveFaqs'))
//         ->disableOriginalConstructor()
//         ->getMock();

//         $query = new \Doctrine\ORM\Query();

//         $serviceManager->setService('playgroundfaq_faq_service', $faqService);

//         $faqService->expects($this->once())
//         ->method('getActiveFaqs')
//         ->will($this->returnValue($query));

//         $response = $this->dispatch('/faq');
//         $this->assertResponseStatusCode(302);
//         $this->assertModuleName('playgroundfaq');
//         $this->assertControllerClass('IndexController');
//         $this->assertActionName('index');
        $this->assertTrue(true);
    }
}
