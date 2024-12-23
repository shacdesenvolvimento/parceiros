<?php
require_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $site = $_POST['site'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    // Tratamento de upload de arquivo
    $logoPath = '';
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $logoPath = $uploadDir . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath);
    }

    $sql = "INSERT INTO parceiro (nome, endereco, telefone, celular, email, site, descricao, status, logo) 
            VALUES (:nome, :endereco, :telefone, :celular, :email, :site, :descricao, :status, :logo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':endereco' => $endereco,
        ':telefone' => $telefone,
        ':celular' => $celular,
        ':email' => $email,
        ':site' => $site,
        ':descricao' => $descricao,
        ':status' => $status,
        ':logo' => $logoPath
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Parceiro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Cadastrar Parceiro</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <!-- Outros campos -->
            <div>
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" required>
            </div>
            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" required>
            </div>
            <div>
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="site">Site:</label>
                <input type="text" name="site" id="site">
            </div>
            <div>
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>
            </div>


            <!---->
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>

</html>