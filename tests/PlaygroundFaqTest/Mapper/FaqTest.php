<?php

namespace PlaygroundFaqTest\Mapper;

use PlaygroundFaqTest\Bootstrap;
use \PlaygroundFaq\Entity\Faq as FaqEntity;

class ThemeTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $faqMapper;

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

   
    public function testInsert()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);
        $this->assertEquals('Test ?', $faq->getQuestion());
    }

    public function testUpdate()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);
        $this->assertEquals('Test ?', $faq->getQuestion());

        $faq->setQuestion("Test 2");
        $faq = $this->getFaqMapper()->update($faq);
        $this->assertEquals('Test 2', $faq->getQuestion());

    }

     //findAll
    public function testFindAll()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("1", sizeof($faqs));

        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("2", sizeof($faqs));
    }

    public function testFindById()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq); 

        $faq2 = $this->getFaqMapper()->findById($faq->getId());
        $this->assertEquals("object", gettype($faq2));
        $this->assertEquals("PlaygroundFaq\Entity\Faq", get_class($faq2));
        $this->assertEquals($faq->getId(), $faq2->getId());
        $this->assertEquals($faq->getQuestion(), $faq2->getQuestion());
    }

    public function testFindBy()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq); 

        $faq2 = $this->getFaqMapper()->findBy(array('answer' =>'answer'));
        $this->assertEquals("array", gettype($faq2));
        $this->assertEquals($faq->getId(), $faq2[0]->getId());
        $this->assertEquals($faq->getQuestion(), $faq2[0]->getQuestion());
    }


    public function testRemove()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?');
        $faq->setAnswer("answer");
        $faq->setIsActive(true);
        $faq->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("1", sizeof($faqs));

        $this->getFaqMapper()->remove($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("0", sizeof($faqs));
    }

       
     public function getFaqMapper()
    {

        if (null === $this->faqMapper) {
            $sm = Bootstrap::getServiceManager();
            $this->faqMapper = $sm->get('playgroundfaq_faq_mapper');
        }

        return $this->faqMapper;
    }

    public function tearDown()
    {
        $dbh = $this->em->getConnection();
        unset($this->sm);
        unset($this->em);
        parent::tearDown();
    }


}
