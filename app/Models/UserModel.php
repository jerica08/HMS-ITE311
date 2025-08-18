<?php

namespace App\Models;  // Define the namespace for the model

use CodeIgniter\Model;  // Import the base Model class

class UserModel extends Model  // Define the UserModel class that extends the base Model
{
    protected $table = 'users';  // Specify the database table name
    protected $primaryKey = 'id';  // Specify the primary key of the table
    protected $allowedFields = ['username', 'email', 'password'];  // Specify the fields that can be mass-assigned
}
 