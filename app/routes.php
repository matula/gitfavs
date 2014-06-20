<?php
ini_set('xdebug.var_display_max_depth', 100);
ini_set('xdebug.var_display_max_children', 1006);
ini_set('xdebug.var_display_max_data', 5024);

Route::get('/', function()
{
    $username = 'matula';
    $user = User::firstOrCreate(['username' => $username]);
    $up = DB::table('favs')->where('user_id', $user->id)->update(['score' => 0]);

    $client = new \Github\Client();
    $client->setOption('user_agent', 'Gitfave');
    $follows = $client->api('user')->following($username);
    $results = [];
    $loop = 1;
    foreach($follows as $follow) {
        $follow_user = User::firstOrCreate(['username' => $follow['login']]);
        $stars = $client->api('user')->starred($follow['login']);
        foreach($stars as $star) {
            $user2 = User::firstOrCreate(['username' => $star['owner']['login']]);
            $repo = Repo::firstOrCreate(['user_id' => $user2->id, 'name' => $star['full_name']]);
            $fav = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo->id]);
            if(!$fav->score) {
                $fav->score = 0;
                $fav->save();
            }
            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $repo->id)->increment('score', 1);
        }

        $watches = $client->api('user')->watched($follow['login']);
        foreach($watches as $watch) {
            $user3 = User::firstOrCreate(['username' => $watch['owner']['login']]);
            $repo2 = Repo::firstOrCreate(['user_id' => $user3->id, 'name' => $watch['full_name']]);
            $wat = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo2->id]);
            if(!$wat->score) {
                $wat->score = 0;
                $wat->save();
            }
            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $repo2->id)->increment('score', 2);
        }

    }

    return Redirect::to('results')->withUserId($user->id);
});

Route::get('results', function() {

   $sql = "SELECT f.score, r.name, u.username
            FROM favs f
            INNER JOIN repos r ON r.id = f.repo_id
            INNER JOIN users u ON u.id = f.user_id WHERE f.user_id = 14
            ORDER BY f.score DESC";

});
