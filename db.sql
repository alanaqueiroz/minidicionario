-- Criação do banco e tabela
CREATE DATABASE IF NOT EXISTS minidicionario;

USE minidicionario;

CREATE TABLE IF NOT EXISTS palavras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    palavra VARCHAR(50) NOT NULL,
    disciplina VARCHAR(50) NOT NULL,
    conceito VARCHAR(1000) NOT NULL
);

-- Inclusão de 20 Palavras de cada disciplina - 1° ETAPA
INSERT INTO palavras (palavra, disciplina, conceito) VALUES
-- Estrutura de Dados
('Algoritmo', 'Estrutura de Dados', 'Sequência finita e lógica de passos que devem ser seguidos para a resolução de um problema específico, como calcular a soma de números ou ordenar uma lista.'),
('Array', 'Estrutura de Dados', 'Estrutura de dados que armazena elementos de mesmo tipo em posições consecutivas de memória, permitindo acesso rápido por meio de índices.'),
('Pilha', 'Estrutura de Dados', 'Estrutura de dados que segue o princípio LIFO (Last In, First Out), onde o último elemento a ser inserido é o primeiro a ser removido, como uma pilha de pratos.'),
('Fila', 'Estrutura de Dados', 'Estrutura que segue o princípio FIFO (First In, First Out), onde o primeiro elemento a entrar é o primeiro a sair, como uma fila de pessoas em um caixa.'),
('Nó', 'Estrutura de Dados', 'Unidade básica de estruturas como listas encadeadas e árvores. Cada nó contém um valor e, geralmente, referências para outros nós.'),
('Grafo', 'Estrutura de Dados', 'Estrutura composta por vértices (ou nós) conectados por arestas, usada para modelar relações, como rotas de mapas ou redes sociais.'),
('Heap', 'Estrutura de Dados', 'Tipo de árvore binária usada como fila de prioridade, onde cada nó pai é maior (ou menor) que seus filhos, dependendo do tipo de heap (máximo ou mínimo).'),
('Hashing', 'Estrutura de Dados', 'Técnica que converte dados em um valor (hash) para armazená-los e buscá-los rapidamente em uma tabela hash.'),
('Árvore', 'Estrutura de Dados', 'Estrutura hierárquica composta por nós conectados por arestas, em que cada nó tem um pai e nós filhos. Usada em algoritmos de busca e armazenamento.'),
('Recursão', 'Estrutura de Dados', 'Técnica em que uma função chama a si mesma repetidamente até alcançar uma condição de parada, útil em problemas que envolvem divisão em subproblemas menores.'),
('Deque', 'Estrutura de Dados', 'Tipo de fila em que a inserção e a remoção de elementos podem ocorrer tanto no início quanto no fim da estrutura.'),
('MergeSort', 'Estrutura de Dados', 'Algoritmo eficiente de ordenação baseado na estratégia dividir e conquistar, que divide o problema em partes menores e resolve cada uma separadamente.'),
('QuickSort', 'Estrutura de Dados', 'Algoritmo de ordenação que escolhe um pivô e organiza elementos menores à esquerda e maiores à direita, dividindo recursivamente o array.'),
('Lista', 'Estrutura de Dados', 'Estrutura de dados que armazena elementos em sequência. Pode ser simplesmente encadeada (cada nó aponta para o próximo) ou duplamente encadeada (com ponteiros para anterior e próximo).'),
('DFS', 'Estrutura de Dados', 'Algoritmo de busca que explora os caminhos de um grafo ou árvore o mais profundamente possível antes de retroceder.'),
('Tabela', 'Estrutura de Dados', 'Estrutura que organiza dados em linhas e colunas, facilitando a busca, inserção e recuperação de valores.'),
('Busca', 'Estrutura de Dados', 'Processo de localizar um elemento em uma estrutura de dados, como arrays, listas ou árvores. Pode ser linear ou binária, dependendo da estrutura.'),
('Ordenação', 'Estrutura de Dados', 'Processo de organizar elementos em uma sequência ordenada (crescente ou decrescente), utilizando algoritmos como Bubble Sort, QuickSort e MergeSort.'),
('Ponteiro', 'Estrutura de Dados', 'Variável que armazena o endereço de memória de outro objeto, muito usada em linguagens como C para manipular estruturas complexas.'),
('Balanceada', 'Estrutura de Dados', 'Propriedade de árvores, como as Árvores AVL, que mantêm a altura das subárvores equilibrada para garantir operações rápidas de busca, inserção e remoção.'),

-- Estatística
('Média', 'Estatística', 'Valor central obtido pela soma de todos os elementos em um conjunto de dados dividida pela quantidade total de elementos.'),
('Moda', 'Estatística', 'Valor que aparece com maior frequência em um conjunto de dados. Pode ser unimodal (um valor predominante) ou multimodal (mais de um valor predominante).'),
('Mediana', 'Estatística', 'Valor que ocupa a posição central em um conjunto de dados ordenados. Se houver um número par de elementos, é calculada pela média dos dois valores centrais.'),
('Amostra', 'Estatística', 'Subconjunto representativo extraído de uma população maior, usado para inferir características dessa população.'),
('População', 'Estatística', 'Conjunto total de elementos ou indivíduos que compartilham características comuns e sobre os quais se deseja tirar conclusões.'),
('Variância', 'Estatística', 'Medida que indica o quão dispersos estão os dados em relação à média. É calculada como o quadrado do desvio padrão.'),
('Frequência', 'Estatística', 'Número de vezes que um valor ocorre em um conjunto de dados. Pode ser absoluta (quantidade exata) ou relativa (proporção em relação ao total).'),
('Histograma', 'Estatística', 'Gráfico de barras que mostra a distribuição de frequências dos dados em intervalos ou classes.'),
('Probabilidade', 'Estatística', 'Medida que quantifica a chance de ocorrência de um evento, variando de 0 (impossível) a 1 (certo).'),
('Outlier', 'Estatística', 'Valor que foge drasticamente do padrão do conjunto de dados, podendo indicar erro ou fenômenos excepcionais.'),
('Erro', 'Estatística', 'Diferença entre o valor observado e o valor esperado ou verdadeiro. Pode ser causado por variação aleatória ou falhas no processo de medição.'),
('Desvio', 'Estatística', 'Diferença entre um valor individual e a média do conjunto de dados. O desvio padrão mede a dispersão desses desvios.'),
('Distribuição', 'Estatística', 'Padrão com que os dados estão espalhados, como a distribuição normal, que tem formato de sino.'),
('Correlação', 'Estatística', 'Medida que avalia o grau de relação entre duas variáveis. Pode ser positiva, negativa ou nula.'),
('Regressão', 'Estatística', 'Técnica estatística usada para modelar e prever a relação entre uma variável dependente e uma ou mais variáveis independentes.'),
('Hipótese', 'Estatística', 'Suposição que é testada estatisticamente para verificar sua validade. Pode ser nula (sem efeito) ou alternativa (com efeito).'),
('Coeficiente', 'Estatística', 'Número que expressa a força e a direção de uma relação entre variáveis, como o coeficiente de correlação.'),
('Intervalo', 'Estatística', 'Faixa de valores que contém uma estimativa do parâmetro populacional com um certo nível de confiança.'),
('Teste', 'Estatística', 'Procedimento estatístico para avaliar a validade de uma hipótese com base em uma amostra de dados.'),
('Normal', 'Estatística', 'Distribuição de probabilidade em forma de sino, simétrica em torno da média e comum em muitos fenômenos naturais.'),

-- Fundamentos de Redes
('IP', 'Fundamentos de Redes', 'Protocolo que define como os dispositivos endereçam e roteiam pacotes de dados na internet. Pode ser IPv4 (endereços numéricos) ou IPv6 (endereços alfanuméricos).'),
('MAC', 'Fundamentos de Redes', 'Endereço físico único atribuído a cada dispositivo de rede, usado para identificá-lo em uma LAN.'),
('TCP', 'Fundamentos de Redes', 'Protocolo confiável de transporte de dados que garante a entrega ordenada e sem perdas entre dois dispositivos.'),
('UDP', 'Fundamentos de Redes', 'Protocolo de transporte que envia dados rapidamente, sem garantias de entrega ou ordem, usado em transmissões de vídeo e voz.'),
('Ping', 'Fundamentos de Redes', 'Comando que testa a conectividade entre dois dispositivos e mede o tempo de resposta em milissegundos.'),
('DNS', 'Fundamentos de Redes', 'Sistema que converte nomes de domínio legíveis (como google.com) em endereços IP numéricos.'),
('Roteador', 'Fundamentos de Redes', 'Dispositivo que conecta diferentes redes e encaminha pacotes de dados entre elas.'),
('Switch', 'Fundamentos de Redes', 'Dispositivo que conecta dispositivos em uma rede local e otimiza o tráfego de dados entre eles.'),
('Firewall', 'Fundamentos de Redes', 'Sistema que filtra e controla o tráfego de entrada e saída de uma rede, protegendo-a contra ataques.'),
('Proxy', 'Fundamentos de Redes', 'Servidor intermediário que atua como ponte entre o usuário e a internet, melhorando segurança e desempenho.'),
('LAN', 'Fundamentos de Redes', 'Rede de área local que conecta dispositivos em uma área restrita, como uma casa ou escritório.'),
('WAN', 'Fundamentos de Redes', 'Rede de longa distância que conecta várias LANs, podendo abranger cidades, países ou continentes.'),
('VPN', 'Fundamentos de Redes', 'Rede privada que usa canais seguros em redes públicas para proteger a comunicação.'),
('SSID', 'Fundamentos de Redes', 'Nome que identifica uma rede Wi-Fi, visível para os dispositivos que buscam conexão.'),
('Topologia', 'Fundamentos de Redes', 'Organização física ou lógica dos dispositivos em uma rede, como topologias em estrela, anel ou barramento.'),
('Gateway', 'Fundamentos de Redes', 'Dispositivo que conecta redes com diferentes protocolos, permitindo a comunicação entre elas.'),
('QoS', 'Fundamentos de Redes', 'Técnicas usadas para priorizar o tráfego em uma rede, garantindo qualidade em serviços como vídeo e voz.'),
('Packet', 'Fundamentos de Redes', 'Pequena unidade de dados que é transmitida individualmente em uma rede e depois recomposta no destino.'),
('Token', 'Fundamentos de Redes', 'Sinal usado em redes de passagem de token para regular o acesso ao meio compartilhado.');