<?php

namespace PlaygroundFaqTest\Entity;

use PlaygroundFaqTest\Bootstrap;
use PlaygroundFaq\Entity\Faq as FaqEntity;

class FaqTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

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

    public function testUpdateChrono()
    {
    	$faq = new FaqEntity();
        sleep(2);
        $faq->updateChrono();
        $this->assertNotEquals($faq->getCreatedAt(), $faq->getUpdatedAt());
    }

    public function testSetId()
    {
    	$faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq->setId(3);
        $this->assertEquals(3, $faq->getId());
        $faq->setId(8);
        $this->assertEquals(8, $faq->getId());
    }

    public function testGetAnswer()
    {
    	$faq = new FaqEntity();
        $faq->setAnswer("answer");
        $this->assertEquals("answer", $faq->getAnswer());
    }

    public function testGetIsActive()
    {
    	$faq = new FaqEntity();
        $faq->setIsActive(true);
        $this->assertTrue($faq->getIsActive());
    }

    public function testPopulate()
    {
    	$faq = new FaqEntity();
        $faq->populate(array("question" => "This is a question ?", "answer" => "This is an answer", "isActive" => 1, "position" => 3));
        $this->assertEquals("This is a question ?", $faq->getQuestion());
        $this->assertEquals("This is an answer", $faq->getAnswer());
        $this->assertEquals(1, $faq->getIsActive());
        $this->assertEquals(3, $faq->getPosition());

        $faq = new FaqEntity();
        $faq->populate(array());
        $this->assertNull($faq->getQuestion());
        $this->assertNull($faq->getAnswer());
        $this->assertEquals(0, $faq->getIsActive());
        $this->assertEquals(0, $faq->getPosition());
    }

    public function tearDown()
    {
        $dbh = $this->em->getConnection();
        unset($this->sm);
        unset($this->em);
        parent::tearDown();
    }
}
