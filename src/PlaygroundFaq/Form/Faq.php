<?php

namespace PlaygroundFaq\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\I18n\Translator\Translator;

class Faq extends ProvidesEventsForm
{
    protected $userEditOptions;
    protected $userEntity;
    protected $serviceManager;

    public function __construct($name = null, Translator $translator)
    {
        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => 0
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'isActive',
            'options' => array(
                'value_options' => array(
                    '0' => $translator->translate('No', 'playgroundfaq'),
                    '1' => $translator->translate('Yes', 'playgroundfaq')
                ),
                'label' => $translator->translate('Actif', 'playgroundfaq')
            )
        ));

        $this->add(array(
                'type' => 'Zend\Form\Element\Textarea',
                'name' => 'question',
                'options' => array(
                        'label' => $translator->translate('Question', 'playgroundfaq')
                ),
                'attributes' => array(
                        'cols' => '10',
                        'rows' => '10',
                        'id' => 'question'
                )
        ));

        $this->add(array(
                'type' => 'Zend\Form\Element\Textarea',
                'name' => 'answer',
                'options' => array(
                        'label' => $translator->translate('Answer', 'playgroundfaq')
                ),
                'attributes' => array(
                        'cols' => '10',
                        'rows' => '10',
                        'id' => 'answer'
                )
        ));

        $this->add(array(
            'name' => 'position',
            'options' => array(
                'label' => $translator->translate('Position', 'playgroundfaq'),
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));
    }
}
