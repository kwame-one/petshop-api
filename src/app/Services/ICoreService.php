<?php

namespace App\Services;

interface ICoreService
{

    public function store(array $data);

    public function update($id, array $data);

    public function find($id, $data = null);

    public function delete($id, $data = null);

    public function findAll();

    public function model();

}
