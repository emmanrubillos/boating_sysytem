@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <?php
        // Assuming you have already set up your database connection in Laravel

        $users = DB::table('users')->select('id', 'name', 'email', 'role_as')->get();

        foreach ($users as $user) {
            echo '<div class="col-md-3 mb-3">';
            echo '<div class="card shadow-small">';
            echo '<img src="' . fetchImage($user->id) . '" class="card-img-top" alt="User Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $user->name . '</h5>';
            echo '<p class="card-text">Email: ' . $user->email . '</p>';
            echo '<p class="card-text">Role: ' . ($user->role_as == 1 ? 'Admin' : 'User') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        function fetchImage($userId)
        {
            $url = 'https://reqres.in/api/users?fbclid=IwAR12Wd3sMaCXoCDUuugkkFFC04qVHXIHXk13uunj07ZffYqpqwNsrRLweXU';
            $data = file_get_contents($url);
            $jsonData = json_decode($data, true);
            $users = $jsonData['data'];

            foreach ($users as $user) {
                if ($user['id'] == $userId) {
                    return $user['avatar'];
                }
            }

            return '';
        }
        ?>
    </div>
</div>
@endsection
