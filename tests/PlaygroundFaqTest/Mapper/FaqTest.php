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
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);
        $this->assertEquals('Test ?', $faq->getQuestion());
        $this->getFaqMapper()->remove($faq);
    }

    public function testInsertTranslation()
    {
        $faq = new FaqEntity();
        $faq->setTranslatableLocale('en_US');
        $faq->populate(array("question" => "This is a question ?", "answer" => "This is an answer", "isActive" => 1, "position" => 3));
        $faq = $this->getFaqMapper()->insert($faq);
        $faq->setTranslatableLocale('fr_FR');
        $faq->populate(array("question" => "C'est une question ?", "answer" => "C'est une réponse"));
        $faq = $this->getFaqMapper()->insert($faq);

        $this->assertCount(1, $this->getFaqMapper()->findAll());
        $this->assertInstanceOf('\PlaygroundFaq\Entity\Faq', current($this->getFaqMapper()->findAll()));

        $faq = current($this->getFaqMapper()->findAll());
        $this->assertEquals("C'est une question ?", $faq->getQuestion());
        $this->assertEquals("C'est une réponse", $faq->getAnswer());
//         $faq->setTranslatableLocale('en_US');
//         $this->assertEquals("This is a question ?", $faq->getQuestion());
//         $this->assertEquals("This is an answer", $faq->getAnswer());
    }

    public function testUpdate()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);
        $this->assertEquals('Test ?', $faq->getQuestion());

        $faq->setQuestion("Test 2");
        $faq = $this->getFaqMapper()->update($faq);
        $this->assertEquals('Test 2', $faq->getQuestion());
        $this->getFaqMapper()->remove($faq);
    }

     //findAll
    public function testFindAll()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("1", sizeof($faqs));

        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals("array", gettype($faqs));
        $this->assertEquals("2", sizeof($faqs));

        foreach ($this->getFaqMapper()->findAll() as $faq) {
            $this->getFaqMapper()->remove($faq);
        }
        $this->assertEmpty($this->getFaqMapper()->findAll());
    }

    public function testFindById()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faq2 = $this->getFaqMapper()->findById($faq->getId());
        $this->assertEquals("object", gettype($faq2));
        $this->assertEquals("PlaygroundFaq\Entity\Faq", get_class($faq2));
        $this->assertEquals($faq->getId(), $faq2->getId());
        $this->assertEquals($faq->getQuestion(), $faq2->getQuestion());

        $this->getFaqMapper()->remove($faq);
        $this->assertEmpty($this->getFaqMapper()->findAll());
    }

    public function testFindBy()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
        $faq = $this->getFaqMapper()->insert($faq);

        $faq2 = $this->getFaqMapper()->findBy(array('answer' =>'answer'));
        $this->assertEquals("array", gettype($faq2));
        $this->assertEquals($faq->getId(), $faq2[0]->getId());
        $this->assertEquals($faq->getQuestion(), $faq2[0]->getQuestion());

        $this->getFaqMapper()->remove($faq);
    }


    public function testRemove()
    {
        $faq = new FaqEntity();
        $faq->setQuestion('Test ?')
            ->setAnswer("answer")
            ->setIsActive(true)
            ->setPosition(1);
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
