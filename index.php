<?php

include "function.php";


// Lista de parceiros
/* $query = "SELECT id, nome, telefone FROM parceiro WHERE status = 1";
$stmt = $pdo->query($query);
$parceiros = $stmt->fetchAll(PDO::FETCH_ASSOC); */
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Parceiros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gerenciamento de Parceiros</h2>
            <a href="cadastrar_parceiro.php" class="btn btn-primary">Criar Parceiro</a>
        </div>
        <table id="parceirosTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parceiros as $parceiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($parceiro['nome']); ?></td>
                        <td><?= htmlspecialchars($parceiro['telefone']); ?></td>
                        <td>
                            <a href="editar_parceiro.php?id=<?= $parceiro['id']; ?>" class="btn btn-sm btn-warning">Atualizar</a>
                            <button class="btn btn-sm btn-danger" onclick="deletarParceiro(<?= $parceiro['id']; ?>)">Deletar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#parceirosTable').DataTable();
        });

        function deletarParceiro(id) {
            if (confirm('Tem certeza que deseja deletar este parceiro?')) {
                $.post('deletar_parceiro.php', {
                    id: id
                }, function(response) {
                    alert(response.message);
                    if (response.success) location.reload();
                }, 'json');
            }
        }
    </script>
</body>

</html> -->
<?php
include "function.php";

$sql = "SELECT * FROM parceiro";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$parceiros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Parceiros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Gerenciar Parceiros</h1>
        <a href="cadastrar_parceiro.php" class="btn btn-primary mb-3">Criar Parceiro</a>
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
</body>

</html>