<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <main>
        <h1>Login</h1>
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="app-cmp-form-detail">
                <label for="app-inp-mail">Email</label>
                <input type="email" id="app-inp-email" name="email" required />
                @error('email')
                    <span></span>
                    <span>{{ $message }}</span>
                @enderror

                <label for="app-inp-password">Password</label>
                <input type="password" id="app-inp-password" name="password" required />
                @error('password')
                    <span></span>
                    <span>{{ $message }}</span>
                @enderror
                
                <div class="app-cmp-form-actions">
                    <button type="submit">Login</button>
                </div>

                <div class="app-cmp-notifications">
                    @error('credentials')
                        <div role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </form>
    </main>
</body>

</html>
