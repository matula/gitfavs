<?php
use Illuminate\Support\Facades\Redirect;

ini_set('xdebug.var_display_max_depth', 100);
ini_set('xdebug.var_display_max_children', 1006);
ini_set('xdebug.var_display_max_data', 5024);

Route::get('/', function () {
    $username = Input::has('username') ? Input::get('username') : 'matula';
    $user     = User::firstOrCreate(['username' => $username]);
    DB::table('favs')->where('user_id', $user->id)->update(['score' => 0]);

    $client = new \Github\Client();
    $client->setOption('user_agent', 'Gitfav');
    $follows = $client->api('user')->following($username);
    $results = [];
    $loop    = 1;
    foreach ($follows as $follow) {
        $follow_user = User::firstOrCreate(['username' => $follow['login']]);
        $stars       = $client->api('user')->starred($follow['login']);
        foreach ($stars as $star) {
            $user2       = User::firstOrCreate(['username' => $star['owner']['login']]);
            $repo        = Repo::firstOrCreate(['user_id' => $user2->id, 'name' => $star['full_name']]);
            $repo->stars = $star['stargazers_count'];
            $repo->language = $star['language'];
            $repo->save();
            $fav = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo->id]);
            if (!$fav->score) {
                $fav->score = 0;
                $fav->save();
            }
            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $repo->id)->increment('score', 1);
        }
        echo '<hr><hr>';
        $watches = $client->api('user')->subscriptions($follow['login']);
        foreach ($watches as $watch) {
            $user3        = User::firstOrCreate(['username' => $watch['owner']['login']]);
            $repo2        = Repo::firstOrCreate(['user_id' => $user3->id, 'name' => $watch['full_name']]);
            $repo2->stars = $watch['stargazers_count'];
            $repo2->language = $watch['language'];
            $repo2->save();
            $wat = Fav::firstOrCreate(['user_id' => $user->id, 'repo_id' => $repo2->id]);
            if (!$wat->score) {
                $wat->score = 0;
                $wat->save();
            }
            DB::table('favs')->where('user_id', $user->id)->where('repo_id', $repo2->id)->increment('score', 2);
        }

    }

    return Redirect::to('list/' . $user->username);
});

Route::get('list/{username}', function ($username) {

    $user = User::where('username', $username)->firstOrFail();
    $user_id = $user->id;
    $sql     = "SELECT f.score, r.name, r.stars, u.username, r.language
            FROM favs f
            INNER JOIN repos r ON r.id = f.repo_id
            INNER JOIN users u ON u.id = f.user_id WHERE f.user_id = $user_id
            ORDER BY f.score DESC, r.stars DESC";

    $results = DB::select($sql);
    echo '<h1>' . $results[0]->username . '</h1>';
    echo '<table border="1">';
    echo '<tr><th>Score</th><th>Stars</th><th>Language</th><th>Repo</th></tr>';
    foreach ($results as $result) {
        echo '<tr>';
        echo '<td>' . $result->score . '</td>';
        echo '<td>' . $result->stars . '</td>';
        echo '<td>' . $result->language . '</td>';
        echo '<td><a href="http://github.com/' . $result->name .'" target="_blank">' . $result->name . '</a></td>';
        echo '</tr>';
    }
    echo '</table>';

});

Route::get('test', function () {
    $client = new \Github\Client();

    $watches = $client->api('user')->subscriptions('matula');
    dd($watches);
});
Route::get('test2', function () {
    $client = new \Github\Client();

    $watches = $client->api('repo')->all();

    dd($watches);
});

