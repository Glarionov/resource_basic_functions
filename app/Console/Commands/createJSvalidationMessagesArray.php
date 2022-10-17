<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createJSvalidationMessagesArray extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:validation_js_array';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $validationErrors = include("resources/lang/en/validation.php");
        $warningMessage = '//!!!WARNING!!! This content is created by the createJSvalidationMessagesArray command module from' .
            "\n//laravel's build-in array of validation errors, listed in en/validation.php file\n";
        $content = $warningMessage . 'let validationErrors = ' . json_encode($validationErrors) . ";\nexport default validationErrors;";
        file_put_contents("resources/js/Helpers/validationErrorMessages.js", $content);
        return 0;
    }
}
