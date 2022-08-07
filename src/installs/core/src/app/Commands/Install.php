<?php

namespace Core\Commands;

use Core\Models\AdminUser;
use Core\Models\Role;
use Illuminate\Console\Command;
Use File;
use Illuminate\Support\Facades\DB;

class Install extends Command
{
	/**
	 * The command signature.
	 *
	 * @var string
	 */
	protected $signature = 'core:install';

	/**
	 * The command description.
	 *
	 * @var string
	 */
	protected $description = 'Install Admin Package. Generate whole structure for /admin.';

	/**
	 * Generate Whole structure for /admin
	 *
	 * @return mixed
	 */
	public function handle()
	{
		try {
			$this->info('Admin installation started...');

			$this->line("\nDB Assistant:");
			if ($this->confirm("Want to set your Database config in the .env file ?", true)) {
				$this->line("DB Assistant Initiated....");
				$dbData = [];

				$dbData['host'] = $this->ask('Database Host', '127.0.0.1');
				$dbData['port'] = $this->ask('Database Port', '3306');

				$dbData['db'] = $this->ask('Database Name', 'test');
				$dbData['db_user'] = $this->ask('Database User', 'root');

				$dbPass = $this->ask('Database Password', false);
				$dbData['db_pass'] = $dbPass ?? '';

				$this->setenv("DB_HOST", $dbData['host']);
				$this->setenv("DB_PORT", $dbData['port']);
				$this->setenv("DB_DATABASE", $dbData['db']);
				$this->setenv("DB_USERNAME", $dbData['db_user']);
				$this->setenv("DB_PASSWORD", $dbData['db_pass']);
			}

			if ($this->confirm("You are ready for the installation?", true)) {
				// Checking database
				$this->line('Checking database connectivity...');
				DB::connection()->reconnect();

				// Running migrations...
				$this->line('Running migrations...');
				$this->call('migrate:fresh');
                $user = AdminUser::first();
                if (!$user) {
                    $this->line('Creating Super Admin User...');
                    $data = [];
                    $data['username'] = $this->ask('Super Admin username', 'super');
                    $data['first_name'] = $this->ask('Super Admin first_name', 'Super');
                    $data['last_name'] = $this->ask('Super Admin last_name', ' Admin');
                    $data['email']    = $this->ask('Super Admin email', 'super@gmail.com');
                    $password = $this->ask('Database Password', '12345678');
                    $data['password'] = bcrypt($password);
                    $user = AdminUser::create($data);
                    $this->info("Super Admin User '" . $data['username'] . "' successfully created.");
                } else {
                    $this->info("Super Admin User '" . $user['username'] . "' exists.");
                }
				$role = Role::whereName('SUPER_ADMIN')->first();
				$user->roles()->attach($role->id);

				$this->info("\nAdmin successfully installed.");
				$this->info("You can now login from yourdomain.com/" . config('core.prefix') . " !!!\n");
			} else {
				$this->error("Installation aborted. Please try again after backup / git. Thank you...");
			}
		} catch (Exception $e) {
			$msg = $e->getMessage();
            $this->error('Install::handle exception: ' . $e);
            throw new Exception('Install::handle Unable to install : ' . $msg, 1);
		}
	}

	/**
	 * Set env with params is key
	 *
	 * @param $param
	 * @param $value
	 * @return void
	 */
	private function setenv($param, $value)
	{
		$envFile = file_get_contents('.env');
		$line = $this->getLineWithString('.env', $param . '=');
		$envFile = str_replace($line, $param . "=" . $value . "\n", $envFile);
		file_put_contents('.env', $envFile);

		$_ENV[$param] = $value;
		putenv($param . "=" . $value);
	}

    /**
     * Get number line in file
     * @param $fileName
     * @param $str
     * @return int|mixed
     */
	private function getLineWithString($fileName, $str) {
		$lines = file($fileName);
		foreach ($lines as $lineNumber => $line) {
			if (strpos($line, $str) !== false) {
				return $line;
			}
		}
		return -1;
	}
}
