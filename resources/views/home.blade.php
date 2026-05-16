<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirakama Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow">
        <div class="container d-flex justify-content-between">

            <span class="navbar-brand fw-bold">
                CHIRAKAMA IMPORTADORA
            </span>

            <button class="btn btn-danger" onclick="logout()">
                Cerrar Sesión
            </button>

        </div>
    </nav>

    <div class="container mt-5">

        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Dashboard de Vehículos
            </h1>

            <p class="text-muted">
                Sistema Profesional de Gestión Vehicular
            </p>

        </div>

        <div class="card shadow-lg border-0">

            <div class="card-header bg-primary text-white fw-bold">
                Vehículos Registrados
            </div>

            <div class="card-body">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>

                    <tbody id="vehicle-table">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script>

        const token = localStorage.getItem('token');

        if (!token) {
            window.location.href = '/login';
        }

        async function loadVehicles() {

            try {

                const response = await fetch('/api/vehicles');

                const data = await response.json();

                console.log(data);

                let table = document.getElementById('vehicle-table');

                table.innerHTML = '';

                data.vehicles.forEach(vehicle => {

                    table.innerHTML += `
                        <tr>
                            <td>${vehicle.id}</td>
                            <td>${vehicle.brand}</td>
                            <td>${vehicle.model}</td>
                            <td>${vehicle.year}</td>
                            <td>$ ${vehicle.price}</td>
                            <td>${vehicle.stock}</td>
                            <td>${vehicle.category?.name ?? 'Sin categoría'}</td>
                        </tr>
                    `;

                });

            } catch(error) {

                console.error(error);

            }

        }

        loadVehicles();

        async function logout() {

            try {

                await fetch('/api/logout', {

                    method: 'POST',

                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }

                });

                localStorage.removeItem('token');

                window.location.href = '/login';

            } catch(error) {

                console.error(error);

            }

        }

    </script>

</body>
</html>