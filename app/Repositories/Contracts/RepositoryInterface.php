<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all();

    public function store(array $data);

    public function show($record);

    public function update(array $data, $record);

    public function delete($record);
}
