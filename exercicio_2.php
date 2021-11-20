<?php
    /* Criando o array para aceitar numeros de 0 a 100 aleatórios */
    $random_numbers_array  = range (0, 100);

    /* Insere os números aleatórios dentro do array */
    shuffle($random_numbers_array);

    /* Pega apenas as 7 primeiras posições do array */
    $random_numbers_array = array_slice($random_numbers_array, 0, 7);

    /* Printando a terceira posição do array */
    echo 'Terceira Posição: '. $random_numbers_array[2] . '</br>';

    /* Variável com todos os itens do array anterior */
    $numbers = implode(', ', $random_numbers_array);   

    /* Novo array com todos os numeros da variável */
    $new_array = explode(', ', $numbers);

    /* Destruindo o antigo array */
    unset($random_numbers_array);

    /* Verifica se há o número 14 dentro do array novo */
    if(array_search(14, $new_array)) {
        echo 'Existe o número 14 no array.'. '</br>';
    } else {
        echo 'Não existe o número 14 no array.'. '</br>';
    }

    /* Excluir se o numero da posição atual for menor do que a anterior */
    foreach($new_array as $key => $valor) {
        if ($key != 0) {
            if ($valor < $new_array[$key-1]) {
                $excluir[] = $new_array[$key];
            }
        }
    }

    /* Exclui os resultados indesejados do laço de repetição e transforma em um novo array */
    $result_array = array_diff($new_array, $excluir);

    array_pop($result_array);

    /* Conta e mostra na tela quantas posições ainda restam pro array */
    echo "O array de resultado possui: ". count($result_array) ." posições.";

    /* Inverte as posições do array */
    array_reverse($result_array);
?>