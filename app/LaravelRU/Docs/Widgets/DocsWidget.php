<?php namespace LaravelRU\Docs\Widgets;

use Config;
use Documentation;
use View;

class DocsWidget {

	public function sidebar($version)
	{
		return Documentation::version($version)->name('documentation')->first()->displayText();
	}

	public function versionSelector($version, $name)
	{
		$all_versions = Config::get('laravel.versions');

		return View::make('docs/version_selector', [
			'all_versions' => $all_versions,
			'current_version' => $version,
			'name' => $name
		])->render();
	}

}
