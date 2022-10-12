<?php
/**
 * MatchController
 * @package admin-match
 * @version 0.0.1
 */

namespace AdminMatch\Controller;

use League\Model\League;
use League\Model\LeagueClassement;
use LibFormatter\Library\Formatter;
use LibForm\Library\Form;
use LibForm\Library\Combiner;
use LibPagination\Library\Paginator;
use Match\Model\Matches;
use Match\Model\MatchResult;
use Team\Model\Team;

class MatchController extends \Admin\Controller
{
    private function getParams(string $title): array{
        return [
            '_meta' => [
                'title' => $title,
                'menus' => ['match', 'all-match']
            ],
            'subtitle' => $title,
            'pages' => null
        ];
    }

    public function editAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_match && !$this->can_i->manage_match_all)
            return $this->show404();

        $match = (object)[
            'status'  => Matches::STATUS_COMING_SOON
        ];

        $id = $this->req->param->id;
        if($id){
            $match = Matches::getOne(['id'=>$id]);
            if(!$match)
                return $this->show404();
            $params = $this->getParams('Edit Match');
            $leaguesse =  League::getOne(['id' => $match->league]);
            $leaguesse = Formatter::format('league', $leaguesse, ['team']);
            $params['team_option'] = array_pluck($leaguesse->team, 'name', 'id');
        }else{
            $params = $this->getParams('Create New Match');
            $params['team_option'] = [];
        }

        $form              = new Form('admin.match.edit');
        $params['form']    = $form;
        $leagues = League::get(['status' => 1]);
        $leagues = array_pluck($leagues, 'title', 'id');
        $leagues[0] = 'Select league';
        $params['leagues'] = $leagues;

        if(!($valid = $form->validate($match)) || !$form->csrfTest('noob'))
            return $this->resp('match/edit', $params);

        if($id){
            if(!Matches::set((array)$valid, ['id'=>$id]))
                deb(Matches::lastError());
        }else{
            if(!($id = Matches::create((array)$valid)))
                deb(Matches::lastError());
        }

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'match',
            'original' => $match,
            'changes'  => $valid
        ]);

        $next = $this->router->to('adminMatch');
        $this->res->redirect($next);
    }

    public function editResultAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_match && !$this->can_i->manage_match_all)
            return $this->show404();

        $id = $this->req->param->id;
        if($id){
            $match = Matches::getOne(['id'=>$id]);
            $match_result = MatchResult::getOne(['match' => $id]);
            $match1 = Formatter::format('match', $match, ['home_team', 'away_team', 'league']);
            if(!$match)
                return $this->show404();
            $params = $this->getParams('Edit Match');
            $params['match'] = $match1;
        }else{
            return $this->show404();
        }

        $form              = new Form('admin.match.edit.result');
        $params['form']    = $form;

        if(!($valid = $form->validate($match_result)) || !$form->csrfTest('noob'))
            return $this->resp('match/edit-result', $params);

        $valid->match = $id;
        if(!Matches::set(['status'=>Matches::STATUS_EXPIRED], ['id'=>$id]))
            deb(Matches::lastError());
        if($idResult = MatchResult::getOne(['match' => $id])){
            if(!MatchResult::set((array)$valid, ['match' => $id]))
                deb(MatchResult::lastError());
        } else {
            if(!($idResult = MatchResult::create((array)$valid)))
                deb(Matches::lastError());
            if(!MatchResult::create((array)$valid))
                deb(MatchResult::lastError());
        }

        $this->event->trigger('match-updated', $match);

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $idResult,
            'parent' => 0,
            'method' => $id ? 2 : 1,
            'type'   => 'match',
            'original' => $match,
            'changes'  => $valid
        ]);

        $next = $this->router->to('adminMatch');
        $this->res->redirect($next);
    }

    public function indexAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_match && !$this->can_i->manage_match_all)
            return $this->show404();

        $cond = $pcond = [];
        if($q = $this->req->getQuery('q'))
            $pcond['q'] = $cond['q'] = $q;

        if($status = $this->req->getQuery('status'))
            $pcond['status'] = $cond['status'] = $status;
        else
            $cond['status'] = ['__op', '>', Matches::STATUS_DELETED];

        if(!$this->can_i->manage_match_all)
            $cond['user'] = $this->user->id;

        list($page, $rpp) = $this->req->getPager(25, 50);

        $matchs = Matches::get($cond, $rpp, $page, ['created'=>false]) ?? [];
        if($matchs)
            $matchs = Formatter::formatMany('match', $matchs, ['home_team', 'away_team', 'league']);

        $params          = $this->getParams('Match');
        $params['matchs'] = $matchs;
        $params['form']  = new Form('admin.match.index');
        $leagues = League::get(['status' => 1]);
        if ($leagues)
            $leagues = array_pluck($leagues, 'title', 'id');
        $leagues[0] = 'Select league';
        $params['leagues'] = $leagues;

        $params['form']->validate( (object)$this->req->get() );

        // pagination
        $params['total'] = $total = Matches::count($cond);
        if($total > $rpp){
            $params['pages'] = new Paginator(
                $this->router->to('adminMatch'),
                $total,
                $page,
                $rpp,
                10,
                $pcond
            );
        }

        $this->resp('match/index', $params);
    }

    public function removeAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->remove_match)
            return $this->show404();

        $id    = $this->req->param->id;
        $match  = Matches::getOne(['id'=>$id]);
        $next  = $this->router->to('adminMatch');
        $form  = new Form('admin.match.index');

        if(!$form->csrfTest('noob'))
            return $this->res->redirect($next);

        $match_set = [
            'status' => Matches::STATUS_DELETED,
        ];
        Matches::set($match_set, ['id'=>$id]);

        $this->event->trigger('match-updated', $match);

        // add the log
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $id,
            'parent' => 0,
            'method' => 3,
            'type'   => 'match',
            'original' => $match,
            'changes'  => null
        ]);

        $this->res->redirect($next);
    }

    public function teamLeagueAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->remove_match)
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

        return $this->ajax(false, 'Success remove team');
    }
}