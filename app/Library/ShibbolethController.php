<?php

namespace StudentAffairsUwm\Shibboleth\Controllers;

use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Console\AppNamespaceDetectorTrait;
use JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use StudentAffairsUwm\Shibboleth\Entitlement;
use StudentAffairsUwm\Shibboleth\ConfigurationBackwardsCompatabilityMapper;

class ShibbolethController extends Controller
{
    /**
     * Service Provider
     * @var Shibalike\SP
     */
    private $sp;

    /**
     * Identity Provider
     * @var Shibalike\IdP
     */
    private $idp;

    /**
     * Configuration
     * @var Shibalike\Config
     */
    private $config;

    /**
     * Constructor
     */
    public function __construct(GenericUser $user = null)
    {
        if (config('shibboleth.emulate_idp') === true) {
            $this->config         = new \Shibalike\Config();
            $this->config->idpUrl = '/emulated/idp';

            $stateManager = $this->getStateManager();

            $this->sp = new \Shibalike\SP($stateManager, $this->config);
            $this->sp->initLazySession();

            $this->idp = new \Shibalike\IdP($stateManager, $this->getAttrStore(), $this->config);
        }

        $this->user = $user;
    }

    /**
     * Create the session, send the user away to the IDP
     * for authentication.
     */
    public function login()
    {
        if (config('shibboleth.emulate_idp') === true) {
            return Redirect::to(action('\\' . __CLASS__ . '@emulateLogin')
                . '?target=' .  action('\\' . __CLASS__ . '@idpAuthenticate'));
        }

        return Redirect::to('https://' . Request::server('SERVER_NAME')
            . ':' . Request::server('SERVER_PORT') . config('shibboleth.idp_login')
            . '?target=' . action('\\' . __CLASS__ . '@idpAuthenticate'));
    }

    /**
     * Setup authentication based on returned server variables
     * from the IdP.
     */
    public function idpAuthenticate()
    {
        if (empty(config('shibboleth.user'))) {
            ConfigurationBackwardsCompatabilityMapper::map();
        }

        foreach (config('shibboleth.user') as $local => $server) {
            $map[$local] = $this->getServerVariable($server);
        }

        if (empty($map['email'])) {
            return abort(403, 'Unauthorized');
        }

        $userClass = config('auth.providers.users.model', 'App\User');

        // Attempt to login with the email, if success, update the user model
        // with data from the Shibboleth headers (if present)
        if (Auth::attempt(array('email' => $map['email']), true)) {
            $user = $userClass::where('email', '=', $map['email'])->first();

            // Update the model as necessary
            $user->update($map);
        }

        // Add user and send through auth.
        elseif (config('shibboleth.add_new_users', true)) {
            $map['password'] = 'shibboleth';
            $user = $userClass::create($map);
        }

        else {
            return abort(403, 'Unauthorized');
        }

        /* Added by fab: 2017-09-06 */
        if ($user->is_admin) {
            $user->last_login = null;
        } else {
            $user->last_login = Carbon::now();
        }
        $user->save();
        $user_name = $map['first_name'] . ' ' . $map['last_name'];
        $institution_identifier = $map['institution_identifier'];
        session(['name' => $user_name]);
        session(['institution_identifier' => $institution_identifier]);
        /* Added by fab: 2017-09-06 */

        Session::regenerate();

        $entitlementString = $this->getServerVariable(config('shibboleth.entitlement'));
        if (!empty($entitlementString)) {
            $entitlements = Entitlement::findInString($entitlementString);
            $user->entitlements()->sync($entitlements);
        }

        $route = config('shibboleth.authenticated');

        if (config('jwtauth') === true) {
            $route .= $this->tokenizeRedirect($user, ['auth_type' => 'idp']);
        }

        return redirect()->intended($route);
    }

    /**
     * Destroy the current session and log the user out, redirect them to the main route.
     */
    public function destroy()
    {
        Auth::logout();
        Session::flush();

        if (config('jwtauth')) {
            $token = JWTAuth::parseToken();
            $token->invalidate();
        }

        if (config('shibboleth.emulate_idp') == true) {
            return Redirect::to(action('\\' . __CLASS__ . '@emulateLogout'));
        }

        return Redirect::to('https://' . Request::server('SERVER_NAME') . config('shibboleth.idp_logout'));
    }

    /**
     * Emulate a login via Shibalike
     */
    public function emulateLogin()
    {
        $from = (Input::get('target') != null) ? Input::get('target') : $this->getServerVariable('HTTP_REFERER');

        $this->sp->makeAuthRequest($from);
        $this->sp->redirect();
    }

    /**
     * Emulate a logout via Shibalike
     */
    public function emulateLogout()
    {
        $this->sp->logout();

        $referer = $this->getServerVariable('HTTP_REFERER');

        die("Goodbye, fair user. <a href='$referer'>Return from whence you came</a>!");
    }

    /**
     * Emulate the 'authentication' via Shibalike
     */
    public function emulateIdp()
    {
        $data = [];

        if (Input::get('username') != null) {
            $username = (Input::get('username') === Input::get('password')) ?
                Input::get('username') : '';

            $userAttrs = $this->idp->fetchAttrs($username);
            if ($userAttrs) {
                $this->idp->markAsAuthenticated($username);
                $this->idp->redirect();
            }

            $data['error'] = 'Incorrect username and/or password';
        }

        return view('IdpLogin', $data);
    }

    /**
     * Function to get an attribute store for Shibalike
     */
    private function getAttrStore()
    {
        return new \Shibalike\Attr\Store\ArrayStore(config('shibboleth.emulate_idp_users'));
    }

    /**
     * Gets a state manager for Shibalike
     */
    private function getStateManager()
    {
        $session = \UserlandSession\SessionBuilder::instance()
            ->setSavePath(sys_get_temp_dir())
            ->setName('SHIBALIKE_BASIC')
            ->build();

        return new \Shibalike\StateManager\UserlandSession($session);
    }

    /**
     * Wrapper function for getting server variables.
     * Since Shibalike injects $_SERVER variables Laravel
     * doesn't pick them up. So depending on if we are
     * using the emulated IdP or a real one, we use the
     * appropriate function.
     */
    private function getServerVariable($variableName)
    {
        if (config('shibboleth.emulate_idp') == true) {
            return isset($_SERVER[$variableName]) ?
                $_SERVER[$variableName] : null;
        }

        $variable = Request::server($variableName);

        return (!empty($variable)) ?
            $variable :
            Request::server('REDIRECT_' . $variableName);
    }

    /*
     * Simple function that allows configuration variables
     * to be either names of views, or redirect routes.
     */
    private function viewOrRedirect($view)
    {
        return (View::exists($view)) ? view($view) : Redirect::to($view);
    }

    /**
     * Uses JWTAuth to tokenize the user and returns a URL query string.
     *
     * @param  App\User $user
     * @param  array $customClaims
     * @return string
     */
    private function tokenizeRedirect($user, $customClaims)
    {
        // This is where we used to setup a session. Now we will setup a token.
        $token = JWTAuth::fromUser($user, $customClaims);

        // We need to pass the token... how?
        // Let's try this.
        return "?token=$token";
    }
}
