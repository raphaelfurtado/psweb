<?php

namespace App\Validation;

use Config\Database;

class CustomRules
{
    /**
     * Valida se a combinação de quadra e número é única.
     *
     * @param string $value Valor do campo (número).
     * @param string $fields Nome do campo relacionado (quadra).
     * @param array $data Todos os dados enviados no formulário.
     * @return bool Retorna true se a combinação for única, false caso contrário.
     */
    public function validateUniqueQuadraNumero(string $value, string $fields, array $data): bool
    {
        $db = Database::connect();
        $quadra = $data[$fields] ?? null;

        if (!$quadra) {
            return false; // Falha se "quadra" não for fornecida
        }

        $query = $db->table('endereco')
            ->where('quadra', $quadra)
            ->where('numero', $value)
            ->countAllResults();

        return $query === 0; // Retorna true se a combinação não existir
    }
}
