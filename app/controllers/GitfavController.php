<?php

class GitfavController extends \BaseController
{

    /**
     * @todo clean this whole mess up
     * @return mixed
     */
    public function process()
    {
        $username = Input::has('username') ? Input::get('username') : false;
        if (!$username) {
            return Redirect::to('list/matula');
        }
        $user = User::firstOrCreate(['username' => $username]);

        // Has user already been processes
        $user_fav = DB::table('favs')->where('user_id', $user->id)->first();
        if ($user_fav) {
            return Redirect::to('list/' . $username);
        }

        $client = new \Github\Client();
        $client->setOption('user_agent', 'Gitfav-mi');
        $follows = $client->api('user')->following($username);
        $results = [];
        $loop    = 1;
        foreach ($follows as $follow) {
            $follow_user = User::where('username', $follow['login'])->first();
            if (count($follow_user) > 0) {
                $githubstars = Githubstar::where('user_id', $follow_user->id)->get();
                if (count($githubstars) > 0) {
                    foreach ($githubstars as $ghstar) {
                        $fav = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $ghstar->repo_id]);
                        if (!$fav->score) {
                            $fav->score = 0;
                            $fav->save();
                        }
                        if ($ghstar->type == 'star') {
                            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $ghstar->repo_id)->increment('score', 1);

                        }
                        if ($ghstar->type == 'watch') {
                            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $ghstar->repo_id)->increment('score', 2);

                        }
                    }
                    continue;
                }
            } else {
                // else proceed
                $follow_user = User::create(['username' => $follow['login']]);
            }
            $stars = $client->api('user')->starred($follow['login']);
            $this->getUserStars($stars, $user, 'star');

            $watches = $client->api('user')->subscriptions($follow['login']);
            $this->getUserStars($watches, $user, 'watch');
        }

        return Redirect::to('list/' . $user->username);
    }


    /**
     * @param $stars
     * @param $user
     * @param $type
     */
    protected function getUserStars($stars, $user, $type)
    {
        foreach ($stars as $star) {
            $star_user      = User::firstOrCreate(['username' => $star['owner']['login']]);
            $repo           = Repo::firstOrCreate(['user_id' => $user->id, 'name' => $star['full_name']]);
            $repo->stars    = $star['stargazers_count'];
            $repo->language = $star['language'];
            $repo->save();
            Githubstar::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo->id, 'type' => $type]);
            $fav = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo->id]);
            if (!$fav->score) {
                $fav->score = 0;
                $fav->save();
            }
            $score = ($type == 'star') ? 1 : 2;
            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $repo->id)->increment('score', $score);
        }
    }

    public function repolist($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        if (!$user) {
            throw new Exception('No user found');
        }
        $user_id = $user->id;
        $sql     = "SELECT f.score, r.name, r.stars, u.username, r.language
            FROM favs f
            INNER JOIN repos r ON r.id = f.repo_id
            INNER JOIN users u ON u.id = f.user_id WHERE f.user_id = $user_id
            ORDER BY f.score DESC, r.stars DESC";

        $results = DB::select($sql);

        if (!$results) {
            throw new \Exception('No repos found', 404);
        }

        return View::make('list')->withResults($results);
    }


}