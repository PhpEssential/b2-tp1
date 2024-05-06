<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <?php include "Header.php" ?>
    <div class="container mt-5">
        <h2 class="mb-4">Liste des utilisateurs</h2>
        <div class="mb-3">
            <a href="user-add" class="btn btn-primary">Ajouter un utilisateur</a>
        </div>
        <table id="userTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Nom d'utilisateur</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- User data will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "language": {
                    "url": "lib/datatable/fr.json"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "user-list-data",
                    "type": "POST"
                },
                "columns": [
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "action" }
                ]
            });
        });
    </script>
</body>
</html>