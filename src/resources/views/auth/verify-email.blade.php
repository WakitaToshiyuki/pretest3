<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtech勤怠アプリ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user_login.css') }}">
</head>

<body>
<header>
    <div class="header">
        <table>
            <tr>
                <th>
                    <h1 class="title">COACHTECH</h1>
                </th>
            </tr>
        </table>
    </div>
</header>
<main>
    <div>
        <p>メールアドレスを確認してください。</p>

        @if (session('status') == 'verification-link-sent')
            <p>確認メールを再送しました。</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">確認メールを再送する</button>
        </form>
    </div>
</main>
</body>

</html>
