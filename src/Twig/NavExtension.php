<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Contracts\Translation\TranslatorInterface;

class NavExtension extends AbstractExtension
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar', [$this, 'getNavs'])
        ];
    }

    public function getNavs()
    {
        return
            [
                'user' =>
                [
                    [
                        'name'=>'Tableau de bord',
                        'icon' => 'fas fa-tachometer-alt',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Dashboard') . ' 1',
                                'path' => 'admin'
                            ]
                        ]
                    ],
                    [
                        'name'=>'Curicilium Vitae',
                        'links' =>
                        [
                            [
                                'name' => 'Mes cvs',
                                'path' => 'client_cv_index'
                            ],
                            [
                                'name' => 'Nouveau Cv',
                                'path' => 'cv_new'
                            ]
                        ]

                    ],
                    // [
                    //     'name'=>'Mes models',
                    //     'path'=>''
                    // ],
                    [
                        'name'=>'Abonnement',
                        'links'=>
                        [
                            ['name'=>'Mes abonnements','path'=>'admin_abonnement_index'],
                            ['name'=>'Nouveau Abonnement','path'=>'admin_abonnement_new']
                        ]
                    ]

                ],
                'app' =>
                [],
                'admin' =>
                [
                    [
                        'name'=>'Modèles',
                        'links'=>'',
                        'name' => 'Modeles',
                        'links' =>
                        [
                            ['name' => 'Listes', 'path' => 'model_index'],
                            ['name' => 'New Model', 'path' => 'model_new']
                        ]
                    ],
                    [
                        'name' => 'Curicilium Vitae',
                        'links' =>
                        [
                            [
                                'name' => 'Listes',
                                'path' => 'cv_index'
                            ],
                            [
                                'name' => 'New CV',
                                'path' => 'cv_new'
                            ]
                        ]

                    ],
                    [
                        'name' => 'user',
                        'icon' => 'fas fa-users',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Users'),
                                'path' => 'user_index',
                            ],
                            [
                                'name' => $this->translator->trans('User'),
                                'path' => 'user_new',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Type Abonnements',
                        'links' =>
                        [
                            ['name' => 'Les Types', 'path' => 'admin_type_abonnement_index'],
                            ['name' => 'New Types', 'path' => 'admin_type_abonnement_new']
                        ]
                    ],
                ],
                'dashboard' =>
                [
                    [
                        'icon' => 'fas fa-tachometer-alt',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Dashboard') . ' 1',
                                'path' => 'admin'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Profil',
                        'path' => 'profile_index',
                    ],
                    [
                        'name' => 'Serivce Cv',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => $this->translator->trans('Home'),
                                'path' => 'home'
                            ]
                        ]
                    ],
                ], 'dashboard_user' =>
                [
                    [
                        'name' => $this->translator->trans('Dashboard'),
                        'icon' => 'fas fa-tachometer-alt',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Dashboard') . ' 1',
                                'path' => 'client_index'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Profil',
                        'path' => 'client_profile_index',
                    ],
                    [
                        'name' => 'App name',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => $this->translator->trans('Home'),
                                'path' => 'home'
                            ]
                        ]
                    ],
                ],
            ];
    }
}
