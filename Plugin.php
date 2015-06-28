<?php namespace Void\Match;

use App;
use Event;
use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'        => 'void.match::lang.plugin.name',
            'description' => 'void.match::lang.plugin.description',
            'author'      => 'Jordan Bobo',
            'icon'        => 'icon-bullseye',
            'homepage'    => 'https://github.com/void/match-plugin',
        ];
    }

    public function registerPermissions()
    {
        return [
            'void.matches.access_matches'  => ['tab' => 'Matches', 'label' => 'Manage Matches'],
        ];
    }

    public function registerNavigation()
    {
        return [
            'match' => [
                'label'       => 'void.match::lang.matches.menu_label',
                'url'         => Backend::url('void/match/matches'),
                'icon'        => 'icon-bullseye',
                'permissions' => ['void.matches.*'],
                'order'       => 500,

                'sideMenu' => [
                    'matches' => [
                        'label'       => 'void.match::lang.matches.all_matches',
                        'icon'        => 'icon-bullseye',
                        'url'         => Backend::url('void/match/matches'),
                        'permissions' => ['void.matches.access_matches'],
                    ],
                ],
            ],
        ];
    }
}
