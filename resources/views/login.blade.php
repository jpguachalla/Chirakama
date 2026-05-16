<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Chirakama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg p-4" style="width: 400px;">

        <h2 class="text-center mb-4">
            CHIRAKAMA
        </h2>

        <form id="login-form">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" id="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">
                Iniciar Sesión
            </button>

        </form>

        <div id="message" class="mt-3 text-center"></div>

    </div>

    <script>

        document.getElementById('login-form')
            .addEventListener('submit', async function(e) {

                e.preventDefault();

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                const response = await fetch('/api/login', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json'
                    },

                    body: JSON.stringify({
                        email,
                        password
                    })

                });

                const data = await response.json();
                
                console.log(data);

                if(response.ok) {

                    localStorage.setItem('token', data.token);

                    window.location.href = '/';

                } else {

                    document.getElementById('message').innerHTML =
                        '<span class="text-danger">Credenciales incorrectas</span>';

                }

            });

    </script>

</body>
</html>