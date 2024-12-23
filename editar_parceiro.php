<?php
require_once 'function.php';

$id = $_GET['id'];
$sql = "SELECT * FROM parceiro WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$parceiro = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $logoPath = $parceiro['logo']; // Manter a logo atual se não houver nova
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $logoPath = $uploadDir . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath);
    }

    $sql = "UPDATE parceiro 
            SET nome = :nome, endereco = :endereco, telefone = :telefone, celular = :celular, 
                email = :email, site = :site, descricao = :descricao, status = :status, logo = :logo
            WHERE id = :id";
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
        ':logo' => $logoPath,
        ':id' => $id
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Parceiro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Parceiro</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($parceiro['nome']) ?>" required>
            </div>
            <!-- Outros campos -->
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
                <?php if (!empty($parceiro['logo'])): ?>
                    <img src="<?= htmlspecialchars($parceiro['logo']) ?>" alt="Logo atual" style="width: 100px; height: 100px; object-fit: cover;" class="mt-2">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>



    <!--produtos por parceiro-->
    <div class="container mt-5">
        <hr>
        <h1>Produtos</h1>
        <a href="cadastrar_parceiro.php" class="btn btn-primary mb-3">Criar Produtos</a>
        <table id="parceirosTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Logo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parceiros as $parceiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($parceiro['nome']) ?></td>
                        <td><?= htmlspecialchars($parceiro['telefone']) ?></td>
                        <td>
                            <?php if (!empty($parceiro['logo'])): ?>
                                <img src="<?= htmlspecialchars($parceiro['logo']) ?>" alt="Logo de <?= htmlspecialchars($parceiro['nome']) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <span>Sem logo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="editar_parceiro.php?id=<?= $parceiro['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <button class="btn btn-danger btn-sm" onclick="deletarParceiro(<?= $parceiro['id'] ?>)">Deletar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#parceirosTable').DataTable();
        });

        function deletarParceiro(id) {
            if (confirm('Tem certeza de que deseja deletar este parceiro?')) {
                window.location.href = `deletar_parceiro.php?id=${id}`;
            }
        }
    </script>
    <!--produtos por parceiro -->








</body>

</html>