<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f3f4f6;
                color: #333;
                line-height: 1.6;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 90%;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                margin-top: 50px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }

            table thead {
                background-color: #007bff;
                color: #fff;
            }

            table th, table td {
                padding: 10px;
                text-align: center;
                border: 1px solid #ddd;
            }

            table tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            table tbody tr:hover {
                background-color: #ddd;
            }

            img {
                border-radius: 8px;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 0;
            }

            .header a {
                text-decoration: none;
                color: #007bff;
                font-weight: 600;
                margin-left: 20px;
            }

            .header a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            @if (Route::has('login'))
                <div class="header">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <div>
                            <a href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                    @endauth
                </div>
            @endif

                <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المدرب</th>
                                        <th>المستوى التعليمي</th>
                                        <th>الجنس</th>
                                        <th>instagram</th>
                                        <th>الشهادة</th>
                                        <th>الصورة الشخصية</th>
                                        <th>صورة الهوية</th>
                                        <th>الإيميل</th>
                                        <th>رقم الجوال</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>لمحة عن المدرب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#</td>
                                            <td>{{ $trainers->name }}</td>
                                            <td>{{ $trainers->educational_level }}</td>
                                            <td>{{ $trainers->gender }}</td>
                                            <td>{{ $trainers->instagram }}</td>
                                            <td><img src="{{ asset('images/trainer/' . $trainers->certificate) }}" alt="{{ $trainers->name }}" width="100" height="50"></td>
                                            <td><img src="{{ asset('images/trainer/' . $trainers->personal_photo) }}" alt="{{ $trainers->name }}" width="100" height="50"></td>
                                            <td><img src="{{ asset('images/trainer/' . $trainers->identity_photo) }}" alt="{{ $trainers->name }}" width="100" height="50"></td>
                                            <td>{{ $trainers->email }}</td>
                                            <td>{{ $trainers->phone }}</td>
                                            <td>{{ $trainers->birth_date }}</td>
                                            <td>{{ $trainers->about }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
        <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    </body>
</html>
