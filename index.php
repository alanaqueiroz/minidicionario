<?php
$host = 'localhost';
$dbname = 'minidicionario';
$username = 'root';
$password = '';

$mensagem = '';
$palavras = [];
$palavraParaEditar = null;
$searchTerm = '';
$editId = null;

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inserir'])) {
    $palavra = $_POST['palavra'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $conceito = $_POST['conceito'] ?? '';
    
    try {
        $stmt = $conn->prepare("INSERT INTO palavras (palavra, disciplina, conceito) VALUES (?, ?, ?)");
        $stmt->execute([$palavra, $disciplina, $conceito]);
        $mensagem = "<div class='alert success'>Palavra inserida com sucesso!</div>";
    } catch(PDOException $e) {
        $mensagem = "<div class='alert error'>Erro ao inserir: " . $e->getMessage() . "</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'] ?? '';
    $palavra = $_POST['palavra'] ?? '';
    $disciplina = $_POST['disciplina'] ?? '';
    $conceito = $_POST['conceito'] ?? '';
    
    try {
        $stmt = $conn->prepare("UPDATE palavras SET palavra = ?, disciplina = ?, conceito = ? WHERE id = ?");
        $stmt->execute([$palavra, $disciplina, $conceito, $id]);
        $mensagem = "<div class='alert success'>Palavra atualizada com sucesso!</div>";
    } catch(PDOException $e) {
        $mensagem = "<div class='alert error'>Erro ao atualizar: " . $e->getMessage() . "</div>";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? '';
    
    try {
        $stmt = $conn->prepare("DELETE FROM palavras WHERE id = ?");
        $stmt->execute([$id]);
        $mensagem = "<div class='alert success'>Palavra removida com sucesso!</div>";
    } catch(PDOException $e) {
        $mensagem = "<div class='alert error'>Erro ao remover: " . $e->getMessage() . "</div>";
    }
}

$searchTerm = $_GET['search'] ?? '';
$editId = $_GET['edit'] ?? null;

try {
    if ($editId) {
        $stmt = $conn->prepare("SELECT * FROM palavras WHERE id = ?");
        $stmt->execute([$editId]);
        $palavraParaEditar = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!empty($searchTerm)) {
        $stmt = $conn->prepare("SELECT * FROM palavras WHERE palavra LIKE ? OR conceito LIKE ? ORDER BY disciplina, palavra");
        $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM palavras ORDER BY disciplina, palavra");
    }
    $palavras = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $mensagem = "<div class='alert error'>Erro ao buscar palavras: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniDicionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
            position: relative;
        }
        
        .page-title {
            text-align: center;
            margin: 20px 0;
            color: #333;
            flex-grow: 1;
        }
        
        .api-btn-container {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .form-section, .list-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .alert.error {
            background-color: #ffdddd;
            border-left: 4px solid #ff3333;
        }
        
        .alert.success {
            background-color: #ddffdd;
            border-left: 4px solid #4bb543;
        }
        
        .discipline-title {
            background-color: #4361ee;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0 10px 0;
        }
        
        .card {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .card-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
        
        .action-buttons a {
            margin-left: 10px;
            color: #6c757d;
        }
        
        .action-buttons a:hover {
            color: #0d6efd;
        }
        
        .action-buttons .delete-btn:hover {
            color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .api-btn-container {
                position: static;
                transform: none;
                margin-top: 10px;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-container">
            <h1 class="page-title">
                <i class="fas fa-book-open me-2"></i><strong>MiniDicionário</strong>
            </h1>
            <div class="api-btn-container">
                <a href="api.html" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-book me-1"></i>Dicionário API
                </a>
            </div>
        </div>
        
        <?php if (!empty($mensagem)) echo $mensagem; ?>
        
        <div class="form-section">
            <h4><strong><?= isset($palavraParaEditar) && $palavraParaEditar ? 'Editar Termo' : 'Adicionar Termo' ?></strong></h4>
            <form method="POST">
                <?php if (isset($palavraParaEditar) && $palavraParaEditar): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($palavraParaEditar['id']) ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="palavra" class="form-label">Palavra</label>
                    <input type="text" class="form-control" id="palavra" name="palavra" 
                           value="<?= isset($palavraParaEditar) ? htmlspecialchars($palavraParaEditar['palavra']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="disciplina" class="form-label">Disciplina</label>
                    <select class="form-select" id="disciplina" name="disciplina" required>
                        <option value="">Selecione...</option>
                        <option value="Estrutura de Dados" <?= (isset($palavraParaEditar) && $palavraParaEditar['disciplina'] == 'Estrutura de Dados') ? 'selected' : '' ?>>Estrutura de Dados</option>
                        <option value="Estatística" <?= (isset($palavraParaEditar) && $palavraParaEditar['disciplina'] == 'Estatística') ? 'selected' : '' ?>>Estatística</option>
                        <option value="Fundamentos de Redes" <?= (isset($palavraParaEditar) && $palavraParaEditar['disciplina'] == 'Fundamentos de Redes') ? 'selected' : '' ?>>Fundamentos de Redes</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="conceito" class="form-label">Conceito</label>
                    <textarea class="form-control" id="conceito" name="conceito" rows="4" required><?= isset($palavraParaEditar) ? htmlspecialchars($palavraParaEditar['conceito']) : '' ?></textarea>
                </div>
                
                <?php if (isset($palavraParaEditar) && $palavraParaEditar): ?>
                    <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
                    <a href="?" class="btn btn-secondary">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="inserir" class="btn btn-primary">Salvar</button>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="list-section">
            <h4><strong>Termos Cadastrados</strong></h4>
            
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Buscar..." value="<?= htmlspecialchars($searchTerm) ?>">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                    <?php if (!empty($searchTerm)): ?>
                        <a href="?" class="btn btn-secondary">Limpar</a>
                    <?php endif; ?>
                </div>
            </form>
            
            <?php
            function highlight($text, $term) {
                return empty($term) ? $text : preg_replace("/(" . preg_quote($term) . ")/i", "<span class='highlight'>$1</span>", $text);
            }

            $grouped = [];
            foreach ($palavras as $p) {
                $grouped[$p['disciplina']][] = $p;
            }
            
            if (!empty($grouped)) {
                foreach ($grouped as $disciplina => $itens) {
                    echo "<div class='discipline-title'>".htmlspecialchars($disciplina)."</div>";
                    
                    foreach ($itens as $item) {
                        echo "<div class='card'>";
                        echo "<div class='card-header'>" . highlight(htmlspecialchars($item['palavra']), $searchTerm);
                        echo "<div class='action-buttons'>";
                        echo "<a href='?edit=" . htmlspecialchars($item['id']) . "' title='Editar'><i class='fas fa-edit'></i></a>";
                        echo "<a href='?delete=" . htmlspecialchars($item['id']) . "' title='Excluir' class='delete-btn' onclick='return confirm(\"Tem certeza que deseja excluir este termo?\")'><i class='fas fa-trash-alt'></i></a>";
                        echo "</div></div>";
                        echo "<div class='card-body'>" . highlight(htmlspecialchars($item['conceito']), $searchTerm) . "</div>";
                        echo "</div>";
                    }
                }
            } else {
                echo "<p>Nenhum termo encontrado.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>