<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'playgroundfaq_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/PlaygroundFaq/Entity'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'PlaygroundFaq\Entity' => 'playgroundfaq_entity'
                )
            )
        )
    ),
    'bjyauthorize' => array(
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'faq'           => array(),
            ),
        ),
    
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    array(array('admin'), 'faq',            array('list','add','edit','delete')),
                ),
            ),
        ),
    
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                
                array('controller' => 'playgroundfaq', 'roles' => array('guest', 'user')),
                
                // Admin area
                array('controller' => 'playgroundfaq_admin', 'roles' => array('admin')),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(),
        'template_path_stack' => array(
             __DIR__ . '/../view/admin',
             __DIR__ . '/../view/frontend'
        ),
    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => 'playgroundfaq'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'playgroundfaq_admin' => 'PlaygroundFaq\Controller\AdminController',
            'playgroundfaq'       => 'PlaygroundFaq\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' =>array(
            'admin' => array(
                'child_routes' => array(
                    'playgroundfaq_admin' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/faq',
                            'defaults' => array(
                                'controller' => 'playgroundfaq_admin',
                                'action' => 'list',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' =>array(
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/list[/:p]',
                                    'defaults' => array(
                                        'controller' => 'playgroundfaq_admin',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),
                            'create' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/create/:faqId',
                                    'defaults' => array(
                                        'controller' => 'playgroundfaq_admin',
                                        'action'     => 'create',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:faqId',
                                    'defaults' => array(
                                        'controller' => 'playgroundfaq_admin',
                                        'action'     => 'edit',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:faqId',
                                    'defaults' => array(
                                        'controller' => 'playgroundfaq_admin',
                                        'action'     => 'remove',
                                        'faqId'     => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'frontend' => array(
                'child_routes' => array(
                    'faq' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => 'faq',
                            'defaults' => array(
                                'controller' => 'playgroundfaq',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'core_layout' => array(
        'PlaygroundFaq' => array(
            'layout' => 'layout/2columns-left',
        	'controllers' => array(
       			'playgroundfaq_admin' => array(
        			'layout' => 'layout/admin',
       			),
       		),
        ),
    ),

    'navigation' => array(
        'default' => array(
            'PlaygroundFaq' => array(
                'label' => 'FAQ',
                'route' => 'faq',
            ),
        ),
        'admin' => array(
            'playgroundfaqadmin' => array(
                'order' => 90,
                'label' => 'FAQ',
                'route' => 'admin/playgroundfaq_admin/list',
                'resource' => 'faq',
                'privilege' => 'list',
                'pages' => array(
                    'list' => array(
                        'label' => 'FAQ list',
                        'route' => 'admin/playgroundfaq_admin/list',
                        'resource' => 'faq',
                        'privilege' => 'list',
                    ),
                    'create' => array(
                        'label' => 'New FAQ',
                        'route' => 'admin/playgroundfaq_admin/create',
                        'resource' => 'faq',
                        'privilege' => 'add',
                    ),
                ),
            ),
        ),
    )
);
