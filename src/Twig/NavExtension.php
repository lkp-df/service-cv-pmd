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
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'getNavs'])
        ];
    }

    public function getNavs()
    {
        return 
        [
            'app'=>
            [

            ],
            'admin'=>
            [
                [
                    'name'=>'user',
                    'icon'=>'fas fa-users',
                    'links'=>[
                        [
                            'name'=>$this->translator->trans('Users'),
                            'path'=>'user_index',
                        ],
                        [
                            'name'=>$this->translator->trans('User'),
                            'path'=>'user_new',
                        ],
                    ]
                ]
            ],
            'user'=>
            [
                
            ],
            'dashboard'=>
            [
                [
                    'name'=>$this->translator->trans('Dashboard'),
                    'icon'=>'fas fa-tachometer-alt',
                    'links'=>[
                        [
                            'name'=>$this->translator->trans('Dashboard').' 1',
                            'path'=>'admin'
                        ]
                    ]
                ],
                [
                    'name'=>'Profil',
                    'path'=>'profile_index',
                ],
                [
                    'name'=>'App name',
                    'icon'=>'fa fa-home',
                    'links'=>
                        [
                            [
                                'name'=>$this->translator->trans('Home'),
                                'path'=>'home'
                            ]
                        ]
                ],
            ],
        ];
    }
}