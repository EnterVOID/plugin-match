<?php namespace Void\Match\Controllers;

use Lang;
use Flash;
use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Void\Match\Models\Match;
use Void\Match\Models\Settings as MatchSettings;

class Matches extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['void.matches.access_matches'];

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Void.Match', 'match', 'matches');
        SettingsManager::setContext('Void.Match', 'settings');
    }

    /**
     * Manually activate a match
     */
    public function update_onActivate($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->attemptActivation($model->activation_code);

        Flash::success(Lang::get('void.match::lang.matches.activated_success'));

        if ($redirect = $this->makeRedirect('update', $model)) {
            return $redirect;
        }
    }

    /**
     * Display matchname field if settings permit
     */
    protected function formExtendFields($form)
    {
        $loginAttribute = MatchSettings::get('login_attribute', MatchSettings::LOGIN_EMAIL);
        if ($loginAttribute != MatchSettings::LOGIN_USERNAME) {
            return;
        }

        if (array_key_exists('matchname', $form->getFields())) {
            $form->getField('matchname')->hidden = false;
        }
    }

    /**
     * Deleted checked matches.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $matchId) {
                if (!$match = Match::find($matchId)) continue;
                $match->delete();
            }

            Flash::success(Lang::get('void.match::lang.matches.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('void.match::lang.matches.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
