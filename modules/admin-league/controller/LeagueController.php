<?php
/**
 * LeagueController
 * @package admin-league
 * @version 0.0.1
 */

namespace AdminLeague\Controller;

use League\Model\LeagueClassement;
use LibFormatter\Library\Formatter;
use LibForm\Library\Form;
use LibForm\Library\Combiner;
use LibPagination\Library\Paginator;
use League\Model\League;
use Match\Model\Matches;
use Team\Model\Team;

class LeagueController extends \Admin\Controller
{
    private function getParams(string $title): array{
        return [
            '_meta' => [
                'title' => $title,
                'menus' => ['league', 'all-league']
            ],
            'subtitle' => $title,
            'pages' => null
        ];
    }

    public function editAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_league && !$this->can_i->manage_league_all)
            return $this->show404();

        $league = (object)['status'=>1, 'description' => ''];

        $id = $this->req->param->id;
        if($id){
            $league = League::getOne(['id'=>$id]);
            if(!$league)
                return $this->show404();
            $params = $this->getParams('Edit League');
        }else{
            $params = $this->getParams('Create New League');
        }

        $form              = new Form('admin.league.edit');
        $params['form']    = $form;

        $c_opts = [
            'cover'      => [null, null, 'json'],
        ];

        $combiner = new Combiner($id, $c_opts, 'league');
        $league = $combiner->prepare($league);

        if(!($valid = $form->validate($league)) || !$form->csrfTest('noob'))
            return $this->resp('league/edit', $params);

        $valid = $combiner->finalize($valid);

        if($id){
            if(!League::set((array)$valid, ['id'=>$id]))
                deb(League::lastError());
        }else{
            if(!($id = League::create((array)$valid)))
                deb(League::lastError());
        }

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'league',
            'original' => $league,
            'changes'  => $valid
        ]);

        $next = $this->router->to('adminLeague');
        $this->res->redirect($next);
    }

    public function indexAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_league && !$this->can_i->manage_league_all)
            return $this->show404();

        $cond = $pcond = [];
        if($q = $this->req->getQuery('q'))
            $pcond['q'] = $cond['q'] = $q;

        if($status = $this->req->getQuery('status'))
            $pcond['status'] = $cond['status'] = $status;
        else
            $cond['status'] = ['__op', '>', 0];

        if(!$this->can_i->manage_league_all)
            $cond['user'] = $this->user->id;

        list($page, $rpp) = $this->req->getPager(25, 50);

        $leagues = League::get($cond, $rpp, $page, ['created'=>false]) ?? [];
        if($leagues)
            $leagues = Formatter::formatMany('league', $leagues, ['user']);

        $params          = $this->getParams('League');
        $params['leagues'] = $leagues;
        $params['form']  = new Form('admin.league.index');

        $params['form']->validate( (object)$this->req->get() );

        // pagination
        $params['total'] = $total = League::count($cond);
        if($total > $rpp){
            $params['pages'] = new Paginator(
                $this->router->to('adminLeague'),
                $total,
                $page,
                $rpp,
                10,
                $pcond
            );
        }

        $this->resp('league/index', $params);
    }

    public function removeAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->remove_league)
            return $this->show404();

        $id    = $this->req->param->id;
        $league  = League::getOne(['id'=>$id]);
        $next  = $this->router->to('adminLeague');
        $form  = new Form('admin.league.index');

        if(!$form->csrfTest('noob'))
            return $this->res->redirect($next);

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => 3,
            'type'   => 'league',
            'original' => $league,
            'changes'  => null
        ]);

        $league_set = [
            'status' => 0,
            'slug'   => time() . '#' . $league->slug
        ];
        League::set($league_set, ['id'=>$id]);

        $this->res->redirect($next);
    }

    public function editTeamAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_league && !$this->can_i->manage_league_all)
            return $this->show404();

        $id = $this->req->param->id;
        if($id){
            $league = League::getOne(['id'=>$id]);
            if(!$league)
                return $this->show404();

            $params = $this->getParams('Edit League Team');
            $league = Formatter::format('league', $league, ['team']);
            $params['league'] = $league;
        }else{
            return $this->show404();
        }

        if($this->req->isAjax()) {
            return $this->ajax(false, $league->team);
        }

        $teams = Team::get(['status'=>1], 15, 1, ['created'=>false]) ?? [];
        if($teams)
            $teams = Formatter::formatMany('team', $teams);
        $params['all_teams'] = $teams;

        return $this->resp('league/edit-team', $params);

        $valid = $combiner->finalize($valid);

        if($id){
            if(!League::set((array)$valid, ['id'=>$id]))
                deb(League::lastError());
        }else{
            if(!($id = League::create((array)$valid)))
                deb(League::lastError());
        }

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'league',
            'original' => $league,
            'changes'  => $valid
        ]);

        $next = $this->router->to('adminLeague');
        $this->res->redirect($next);
    }

    public function addTeamAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_league && !$this->can_i->manage_league_all)
            return $this->show404();

        $valid = [
            'league' => $this->req->getPost('league'),
            'team' => $this->req->getPost('team'),
        ];

        if ($id = LeagueClassement::getOne($valid)) {
            if(!LeagueClassement::set((array)$valid, ['id'=>$id]))
                deb(League::lastError());
        } else {
            if(!($id = LeagueClassement::create((array)$valid)))
                deb(League::lastError());
        }

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'league',
            'original' => [],
            'changes'  => $valid
        ]);

        return $this->ajax(false, 'Success add team');
    }

    public function removeTeamAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_league && !$this->can_i->manage_league_all)
            return $this->show404();

        $valid = [
            'league' => $this->req->getPost('league'),
            'team' => $this->req->getPost('team'),
        ];

        if ($id = LeagueClassement::getOne($valid)) {
            LeagueClassement::remove(['id' =>$id->id]);
        }

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'league',
            'original' => [],
            'changes'  => $valid
        ]);

        return $this->ajax(false, 'Success remove team');
    }

    public static function updateClassementAction($match){
        return true;
    }
}