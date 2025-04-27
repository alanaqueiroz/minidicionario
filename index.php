<?php
$host = 'localhost';
$dbname = 'minidicionario';
$username = 'root';
$password = '';

$palavras = [];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inserir'])) {
    $palavra = $_POST['palavra'];
    $disciplina = $_POST['disciplina'];
    $conceito = $_POST['conceito'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO palavras (palavra, disciplina, conceito) 
                               VALUES (:palavra, :disciplina, :conceito)");
        $stmt->bindParam(':palavra', $palavra);
        $stmt->bindParam(':disciplina', $disciplina);
        $stmt->bindParam(':conceito', $conceito);
        $stmt->execute();
        
        echo "<div class='alert alert-success'>Palavra inserida com sucesso!</div>";
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erro ao inserir: " . $e->getMessage() . "</div>";
    }
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

try {
    if (!empty($searchTerm)) {
        $stmt = $conn->prepare("SELECT * FROM palavras 
                               WHERE palavra LIKE :search OR conceito LIKE :search
                               ORDER BY disciplina, palavra");
        $searchParam = "%$searchTerm%";
        $stmt->bindParam(':search', $searchParam);
        $stmt->execute();
        $palavras = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->query("SELECT * FROM palavras ORDER BY disciplina, palavra");
        $palavras = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo "<div class='alert alert-danger'>Erro ao buscar palavras: " . $e->getMessage() . "</div>";
    $palavras = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniDicionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4bb543;
            --danger-color: #ff3333;
            --warning-color: #ffcc00;
        }
        
        body {
            background-color: #f5f7ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .navbar-brand span {
            color: var(--accent-color);
        }
        
        .form-container, .dictionary-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .disciplina-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 20px;
            margin: 30px 0 15px 0;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .disciplina-header i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 2px solid var(--accent-color);
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-color);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline-secondary {
            border-radius: 8px;
            padding: 10px 20px;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }
        
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
        }
        
        .highlight {
            background-color: #fffacd;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .input-group {
            position: relative;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .floating-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-5px) scale(1.05);
            color: white;
        }
        
        @media (max-width: 768px) {
            .form-container, .dictionary-container {
                padding: 1.5rem;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" style="color: inherit; text-decoration: none; cursor: default;">
                <i class="fas fa-book-open me-2"></i>Mini<span>Dicionário</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#insert-section"><i class="fas fa-plus-circle me-1"></i> Inserir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dictionary-section"><i class="fas fa-book me-1"></i> Cadastrados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="api.html"><i class="fas fa-book me-1"></i>Dicionário API</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container" id="insert-section">
            <h2 class="mb-4"><i class="fas fa-plus-circle me-2"></i>Inserir</h2>

            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="palavra" class="form-label">Palavra</label>
                        <input type="text" class="form-control" id="palavra" name="palavra" required>
                    </div>
                    <div class="col-md-6">
                        <label for="disciplina" class="form-label">Disciplina</label>
                        <select class="form-select" id="disciplina" name="disciplina" required>
                            <option value="">Selecione uma disciplina...</option>
                            <option value="Estrutura de Dados">Estrutura de Dados</option>
                            <option value="Estatística">Estatística</option>
                            <option value="Fundamentos de Redes">Fundamentos de Redes</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="conceito" class="form-label">Conceito</label>
                    <textarea class="form-control" id="conceito" name="conceito" rows="4" required></textarea>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" name="inserir" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="dictionary-container" id="dictionary-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="fas fa-book me-2"></i>Cadastrados</h2>
                <span class="badge bg-primary rounded-pill"><?php echo count($palavras); ?> termos</span>
            </div>
            
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Digite palavra, conceito ou disciplina..." 
                           value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                    <?php if (!empty($searchTerm)): ?>
                        <a href="?" class="btn btn-outline-danger ms-2">
                            <i class="fas fa-times me-1"></i> Limpar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
            
            <?php if (!empty($searchTerm)): ?>
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i> Resultados para: <strong><?php echo htmlspecialchars($searchTerm); ?></strong>
                </div>
            <?php endif; ?>
            
            <?php
            function highlightText($text, $searchTerm) {
                if (empty($searchTerm)) return $text;
                return preg_replace("/(" . preg_quote($searchTerm) . ")/i", "<span class='highlight'>$1</span>", $text);
            }

            $palavras_por_disciplina = [];
            foreach ($palavras as $palavra) {
                $disciplina = $palavra['disciplina'];
                if (!isset($palavras_por_disciplina[$disciplina])) {
                    $palavras_por_disciplina[$disciplina] = [];
                }
                $palavras_por_disciplina[$disciplina][] = $palavra;
            }
            
            if (!empty($palavras_por_disciplina)) {
                foreach ($palavras_por_disciplina as $disciplina => $palavras_disciplina) {
                    $icon = '';
                    switch ($disciplina) {
                        case 'Estrutura de Dados':
                            $icon = 'fas fa-code';
                            break;
                        case 'Estatística':
                            $icon = 'fas fa-chart-bar';
                            break;
                        case 'Fundamentos de Redes':
                            $icon = 'fas fa-network-wired';
                            break;
                        default:
                            $icon = 'fas fa-book';
                    }
                    
                    echo "<div class='disciplina-header'><i class='$icon'></i>$disciplina</div>";
                    
                    foreach ($palavras_disciplina as $palavra) {
                        $palavraHighlighted = highlightText($palavra['palavra'], $searchTerm);
                        $conceitoHighlighted = highlightText($palavra['conceito'], $searchTerm);
                        
                        echo "<div class='card'>";
                        echo "<div class='card-header'>";
                        echo "<span>{$palavraHighlighted}</span>";
                        echo "<span class='badge bg-light text-primary'>{$palavra['disciplina']}</span>";
                        echo "</div>";
                        echo "<div class='card-body'>";
                        echo "<p class='card-text'>{$conceitoHighlighted}</p>";
                        echo "</div></div>";
                    }
                }
            } elseif (empty($palavras)) {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-book-open"></i>';
                echo '<h3 class="mt-3">Nenhum termo cadastrado</h3>';
                echo '<p class="text-muted">Comece adicionando novos termos ao dicionário</p>';
                echo '</div>';
            } elseif (!empty($searchTerm) && count($palavras) === 0) {
                echo '<div class="empty-state">';
                echo '<i class="fas fa-search"></i>';
                echo '<h3 class="mt-3">Nenhum resultado encontrado</h3>';
                echo '<p class="text-muted">Tente ajustar sua busca ou verifique a ortografia</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <a href="#insert-section" class="floating-btn" style="border: none; text-decoration: none;">
        <i class="fas fa-plus"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>