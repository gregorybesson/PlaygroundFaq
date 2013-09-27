<?php

namespace PlaygroundFaqTest\Form;

use PlaygroundFaqTest\Bootstrap;

class FaqTest extends \PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $form;

    public function setUp()
    {
        parent::setUp();
    }

   
    public function testValid()
    {
        $data = array('question' => 'test');
        $this->getForm()->setData($data);
        $this->assertFalse($this->form->isValid());


        $data = array('question' => 'test',
                      'answer' => 'testa',
                      'isActive' => true);
        $this->getForm()->setData($data);
        $this->assertFalse($this->form->isValid());
    }

    public function getForm()
    {
        if (null === $this->form) {
            $sm = Bootstrap::getServiceManager();
            $this->form = $sm->get('playgroundfaq_faq_form');
        }

        return $this->form;
    }
}
