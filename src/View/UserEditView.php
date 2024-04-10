<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier l'utilisateur</h2>
        <form action="user-edit-action" method="POST">
            <input type="hidden" id="userId" name="userId" value="<?= $data["user"]["id"]; ?>">
            <div class="form-group">
                <label for="name">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $data["user"]["name"]; ?>">
            </div>
            <div class="form-group">
                <label for="email">Adresse email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $data["user"]["email"]; ?>">
            </div>
            <div class="form-group">
                <label for="role">Rôle:</label>
                <select class="form-control" id="role" name="role">
                    <option value="1" <?= ($data["user"]["role"] == 1) ? "selected" : "" ?>>Admin</option>
                    <option value="2" <?= ($data["user"]["role"] == 2) ? "selected" : "" ?>>Employé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>