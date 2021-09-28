<?php

namespace App\Repositories;

interface RepositoryTemplate
{
	public static function find();
	public static function findById(int $id); 
}
