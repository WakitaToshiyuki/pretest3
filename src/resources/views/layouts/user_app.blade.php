<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtech勤怠アプリ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user_common.css') }}">
  @yield('css')
</head>

<body>
<header>
  <div class="header">
    <table>
      <tr>
        <th>
          <h1 class="title">COACHTECH</h1>
        </th>
        <th>
          <a href="/">勤怠</a>
        </th>
        <th>
          <a href="/list">勤怠一覧</a>
        </th>
        <th>
          <a href="/mypage">申請</a>
        </th>
        <th>
          <form action="/logout" method="post">
          @csrf
            <button class="header-nav__button">ログアウト</button>
          </form>
        </th>
      </tr>
    </table>

  </div>
</header>
<main>
  @yield('content')
</main>
</body>

</html>
