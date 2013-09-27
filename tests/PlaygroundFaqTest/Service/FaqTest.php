<?php

namespace PlaygroundFaqTest\Service;

use PlaygroundFaqTest\Bootstrap;
use \PlaygroundFaq\Entity\Faq as FaqEntity;

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

   
    public function testGetActiveFaqs() 
    {

        $faqt1 = new FaqEntity;
        $faqt1->setQuestion('Test ?');
        $faqt1->setAnswer("answer");
        $faqt1->setIsActive(true);
        $faqt1->setPosition(1);
        $this->getFaqMapper()->insert($faqt1);

        $faqt2 = new FaqEntity;
        $faqt2->setQuestion('Test2 ?');
        $faqt2->setAnswer("answer2");
        $faqt2->setIsActive(true);
        $faqt2->setPosition(2);
        $this->getFaqMapper()->insert($faqt2);

        $faqt3 = new FaqEntity;
        $faqt3->setQuestion('Test3 ?');
        $faqt3->setAnswer("answer3");
        $faqt3->setIsActive(false);
        $faqt3->setPosition(3);
        $this->getFaqMapper()->insert($faqt3);
        
        $faqs = $this->getFaqService()->getActiveFaqs();
        $this->assertEquals(2, sizeof($faqs));
        $this->clean();
    }


    public function testGetAllFaqs() 
    {
        
        $faqaf = new FaqEntity;
        $faqaf->setQuestion('Testfaqaf ?');
        $faqaf->setAnswer("answerfaqaf");
        $faqaf->setIsActive(true);
        $faqaf->setPosition(1);
        $this->getFaqMapper()->insert($faqaf);

        $faqaf = new FaqEntity;
        $faqaf->setQuestion('Testfaqaf2 ?');
        $faqaf->setAnswer("answerfaqaf2");
        $faqaf->setIsActive(true);
        $faqaf->setPosition(2);
        $this->getFaqMapper()->insert($faqaf);

        $faq3 = new FaqEntity;
        $faq3->setQuestion('Test3 ?');
        $faq3->setAnswer("answer3");
        $faq3->setIsActive(true);
        $faq3->setPosition(3);
        $this->getFaqMapper()->insert($faq3);

        $faq4 = new FaqEntity;
        $faq4->setQuestion('Test4 ?');
        $faq4->setAnswer("answer4");
        $faq4->setIsActive(true);
        $faq4->setPosition(4);
        $this->getFaqMapper()->insert($faq4);


        $faqs = $this->getFaqMapper()->findAll();
        $this->assertEquals(4, sizeof($faqs));

        $faqs = $this->getFaqService()->getAllFaqs();
        $this->assertEquals(4, sizeof($faqs));
        $this->assertEquals(1, $faqs[0]->getPosition());
        $this->assertEquals(2, $faqs[1]->getPosition());
        $this->assertEquals(3, $faqs[2]->getPosition());
        $this->assertEquals(4, $faqs[3]->getPosition());
        $this->clean();

    }
  
    public function clean()
    {
        foreach ($this->getFaqMapper()->findAll() as $faq) {
            $this->getFaqMapper()->remove($faq);
        }
    }
       
    public function getFaqMapper()
    {

        if (null === $this->faqMapper) {
            $sm = Bootstrap::getServiceManager();
            $this->faqMapper = $sm->get('playgroundfaq_faq_mapper');
        }

        return $this->faqMapper;
    }


    public function getFaqService()
    {
       if (null === $this->faqService) {
            $sm = Bootstrap::getServiceManager();
            $this->faqService = $sm->get('playgroundfaq_faq_service');
        }

        return $this->faqService;
    }


}
