<?php

class RuleManager
{

		private $yaml_rules;

		public function __construct()
		{
			$config = new Configuration();

			if (!$this->YAMLExists())
			{
				$log = new LogEngine();
				$log->setInstanceSeverity("CRITICAL");

				$log->setMessage("CRITICAL ERROR! One or more dependencies are not met. This warning usually means that you have not installed libYAML and/or the PHP YAML extension. Please correct such errors and try again.");
				$log->writeLog();
				
				throw new RuntimeException("A runtime error has been detected. Please check your logfile.");
			}
			// There may be a bug here, if you change the path in the config file, the path may no longer
			// be valid
			$this->yaml_rules = yaml_parse("../", $config->getIniValue("RulesFile", "main"));

			if ($this->yaml_rules == false) // Can't use ternary operator here
			{
				$log = new LogEngine();
				$log->setInstanceSeverity("ERROR");
				$log->setMessage("ERROR! Unable to parse rules file. Please check your config file.");

				$log->writeLog();
				throw new IllegalStateException("WARNING: An error has been detected. Please check your logfile.");
			}



		}

		private function YAMLExists()
		{
			return function_exists("yaml_parse");
		}
		// var dumps yaml rules
		public function testYamlData()
		{
			var_dump($this->yaml_rules);
		}



}
