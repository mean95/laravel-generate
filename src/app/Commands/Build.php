<?php

namespace Install\Commands;

use Illuminate\Console\Command;
Use File;

class Build extends Command
{
	/**
	 * The command signature.
	 *
	 * @var string
	 */
	protected $signature = 'core:build';
	/**
	 * The command description.
	 *
	 * @var string
	 */
	protected $description = 'Build module laravel generate';

	/**
	 * Root directory to receive files
	 *
	 * @var string
	 */
	protected $toCore = 'core/';

	/**
	 * Path vendor core 
	 * @var string
	 */
	protected $fromCore = 'vendor/mean95/build-generate/src/installs/core';

	/**
	 * Path vendor public 
	 * @var string
	 */
	protected $fromPublic = 'vendor/mean95/build-generate/src/installs/public';

	/**
	 * Generate Whole structure for /admin
	 *
	 * @return mixed
	 */
	public function handle()
	{
		try {
			$this->info('Build module generate started...');

			$fromCore = base_path($this->fromCore);
			$fromPublic = base_path($this->fromPublic);
			$toCore = base_path($this->toCore);

			$this->info('from: ' . $fromCore . ' to: ' . $toCore);

			if ($this->confirm("You are ready for the building module generate?", true)) {
				// Copy folder app
				File::makeDirectory($toCore, 0777, true, true);
				File::copyDirectory($fromCore, $toCore);

				//Copy file css platform
				$toPublic = public_path();
                File::copyDirectory($fromPublic, $toPublic);

				$this->info("\nAdmin successfully build module generate.");
			} else {
				$this->error("Building aborted. Please try again. Thank you...");
			}
		} catch (Exception $e) {
			$msg = $e->getMessage();
            $this->error('Build::handle exception: ' . $e);
            throw new Exception('Build::handle Unable to install : ' . $msg, 1);
		}
	}
}
