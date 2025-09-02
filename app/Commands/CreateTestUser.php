<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateTestUser extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'create:testuser';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Creates a test admin user for the HMS system';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'create:testuser';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // Check if users table exists and has the right structure
        $result = $db->query("SHOW TABLES LIKE 'users'");
        if ($result->getNumRows() == 0) {
            CLI::write("Users table doesn't exist. Creating it...", 'yellow');
            
            // Create users table
            $sql = "CREATE TABLE users (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'doctor', 'nurse', 'receptionist', 'pharmacist', 'laboratorist', 'accountant', 'it_staff') DEFAULT 'receptionist',
                email VARCHAR(100) NOT NULL
            )";
            
            $db->query($sql);
            CLI::write("Users table created successfully.", 'green');
        }

        // Check if admin user already exists
        $result = $db->query("SELECT * FROM users WHERE email = 'admin@hms.com'");
        if ($result->getNumRows() > 0) {
            CLI::write("Admin user already exists.", 'yellow');
        } else {
            // Create admin user
            $password = password_hash('admin123', PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)";
            $db->query($sql, ['admin', $password, 'admin', 'admin@hms.com']);
            CLI::write("Admin user created successfully.", 'green');
            CLI::write("Email: admin@hms.com", 'cyan');
            CLI::write("Password: admin123", 'cyan');
        }

        CLI::write("Script completed.", 'green');
    }
}
