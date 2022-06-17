<?php

class Orders extends DBTools
{
    public function getOrders($data)
    {
        $query = "SELECT * FROM orders WHERE 1 ";

        if ($data['origen']) {
            $query .= " AND origen LIKE '%{$data['origen']}%'";
        }

        if ($data['destino']) {
            $query .= " AND destino LIKE '%{$data['destino']}%'";
        }

        if ($data['salida']) {
            $query .= " AND salida LIKE '%{$data['salida']}%'";
        }

        if ($data['retorno']) {
            $query .= " AND retorno LIKE '%{$data['retorno']}%'";
        }

        if ($data['total']) {
            $query .= " AND total LIKE '%{$data['total']}%'";
        }

        if ($data['fecha']) {
            $query .= " AND fecha LIKE '%{$data['fecha']}%'";
        }

        if ($data['hora']) {
            $query .= " AND hora LIKE '%{$data['hora']}%'";
        }

        return $this->exec($query);
    }
}
