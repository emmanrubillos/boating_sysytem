<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
            /* Add your custom CSS styles here */
            body {
                background-color: #f2f2f2;
                font-family: Arial, sans-serif;
                padding-top: 100px;
            }
    
            .container {
                max-width: 500px;
            }
    
            .jumbotron {
                background-color: #ffffff;
                padding: 40px;
            }
    
            h1 {
                color: #333333;
                font-size: 36px;
                margin-bottom: 30px;
            }
    
            .btn-custom {
                background-color: #333333;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1>Boating System</h1>
                <p>This is the homepage of my website.</p>
                <hr>
                <div class="text-center">
                    @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                </div>
            </div>
        </div>
    </body>
</html>
