<?php

namespace AILearn\ai_learn;


use AILearn\ai_learn\Controller\AdminController;
use AILearn\ai_learn\Controller\formController;

class AILearnPlugin
{

	const TRANSIENT_ailearn_ACTIVATED = 'ailearn_activated';
	public function __construct(string $file)
	{
		register_activation_hook($file, [$this, 'plugin_activation']);
		add_action('admin_notices', [$this, 'notice_activation']);
		$formController = new formController();
		if (is_admin()) {
			$adminController = new AdminController();
		}
	}

	public function plugin_activation(): void
	{
		set_transient(self::TRANSIENT_ailearn_ACTIVATED, true);
	}


	public function notice_activation(): void
	{
		if (get_transient(self::TRANSIENT_ailearn_ACTIVATED)) {
			self::render('notices', [
				'message' => "Merci d'avoir activé <strong>AILearn</strong> !"
			]);
			delete_transient(self::TRANSIENT_ailearn_ACTIVATED);
		}
	}

	public static function render(string $name, array $args = []): void
	{
		extract($args);

		$file = AILEARN_PLUGIN_DIR . "views/$name.php";

		ob_start();

		include_once($file);

		echo ob_get_clean();
	}
}
