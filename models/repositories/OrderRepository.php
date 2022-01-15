<?php

namespace models\repositories;

class OrderRepository extends Repository
{

    public function getTableName(): string
    {
        return 'order_contacts';
    }
}