<?php
/**
 * TeamController
 * @package admin-team
 * @version 0.0.1
 */

namespace AdminTeam\Controller;

use LibFormatter\Library\Formatter;
use LibForm\Library\Form;
use LibForm\Library\Combiner;
use LibPagination\Library\Paginator;
use Team\Model\Team;

class TeamController extends \Admin\Controller
{
    private function getParams(string $title): array{
        return [
            '_meta' => [
                'title' => $title,
                'menus' => ['team', 'all-team']
            ],
            'subtitle' => $title,
            'pages' => null
        ];
    }

    public function editAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_team && !$this->can_i->manage_team_all)
            return $this->show404();

        $team = (object)[
            'description' => '',
            'status'  => 1
        ];

        $id = $this->req->param->id;
        if($id){
            $team = Team::getOne(['id'=>$id]);
            if(!$team)
                return $this->show404();
            $params = $this->getParams('Edit Team');
        }else{
            $params = $this->getParams('Create New Team');
        }

        $form              = new Form('admin.team.edit');
        $params['form']    = $form;

        $c_opts = [
            'cover'      => [null,                  null, 'json'],
        ];

        $combiner = new Combiner($id, $c_opts, 'team');
        $team    = $combiner->prepare($team);

        $params['opts'] = $combiner->getOptions();
        
        if(!($valid = $form->validate($team)) || !$form->csrfTest('noob'))
            return $this->resp('team/edit', $params);
        
        $valid = $combiner->finalize($valid);

        if($id){
            if(!Team::set((array)$valid, ['id'=>$id]))
                deb(Team::lastError());
        }else{
            if(!($id = Team::create((array)$valid)))
                deb(Team::lastError());

        }

        $combiner->save($id, $this->user->id);

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'team',
            'original' => $team,
            'changes'  => $valid
        ]);

        $next = $this->router->to('adminTeam');
        $this->res->redirect($next);
    }

    public function indexAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_team && !$this->can_i->manage_team_all)
            return $this->show404();

        $cond = $pcond = [];
        if($q = $this->req->getQuery('q'))
            $pcond['q'] = $cond['q'] = $q;

        if($status = $this->req->getQuery('status'))
            $pcond['status'] = $cond['status'] = $status;
        else
            $cond['status'] = ['__op', '>', 0];

        if(!$this->can_i->manage_team_all)
            $cond['user'] = $this->user->id;

        list($page, $rpp) = $this->req->getPager(25, 50);

        $teams = Team::get($cond, $rpp, $page, ['created'=>false]) ?? [];
        if($teams)
            $teams = Formatter::formatMany('team', $teams);

        $params          = $this->getParams('Team');
        $params['teams'] = $teams;
        $params['form']  = new Form('admin.team.index');

        $params['form']->validate( (object)$this->req->get() );

        // pagination
        $params['total'] = $total = Team::count($cond);
        if($total > $rpp){
            $params['pages'] = new Paginator(
                $this->router->to('adminTeam'),
                $total,
                $page,
                $rpp,
                10,
                $pcond
            );
        }

        $this->resp('team/index', $params);
    }

    public function removeAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->remove_team)
            return $this->show404();

        $id    = $this->req->param->id;
        $team  = Team::getOne(['id'=>$id]);
        $next  = $this->router->to('adminTeam');
        $form  = new Form('admin.team.index');

        if(!$form->csrfTest('noob'))
            return $this->res->redirect($next);

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => 3,
            'type'   => 'team',
            'original' => $team,
            'changes'  => null
        ]);

        $team_set = [
            'status' => 0,
        ];
        Team::set($team_set, ['id'=>$id]);

        $this->res->redirect($next);
    }
}