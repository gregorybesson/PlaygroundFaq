<?php

namespace PlaygroundFaq\Options;

class ModuleOptions
{
    /**
     * @var string
     */
    protected $faqEntityClass = 'PlaygroundFaq\Entity\Faq';

    /**
     * @var bool
     */
    protected $enableDefaultEntities = true;

    protected $faqMapper = 'PlaygroundFaq\Mapper\Faq';

    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    public function setFaqMapper($faqMapper)
    {
        $this->faqMapper = $faqMapper;
    }

    public function getFaqMapper()
    {
        return $this->faqMapper;
    }

    /**
     * set faq entity class name
     *
     * @param  string        $faqEntityClass
     * @return ModuleOptions
     */
    public function setFaqEntityClass($faqEntityClass)
    {
        $this->faqEntityClass = $faqEntityClass;

        return $this;
    }

    /**
     * get faq entity class name
     *
     * @return string
     */
    public function getFaqEntityClass()
    {
        return $this->faqEntityClass;
    }

    /**
     * @param boolean $enableDefaultEntities
     */
    public function setEnableDefaultEntities($enableDefaultEntities)
    {
        $this->enableDefaultEntities = $enableDefaultEntities;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnableDefaultEntities()
    {
        return $this->enableDefaultEntities;
    }
}
