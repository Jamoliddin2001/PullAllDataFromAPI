<?php

namespace App\Console\Commands;

use App\CustomClasses\AES\AES;
use App\Models\Key;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AddKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-key {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add key and cipher for requests';

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
     */
    public function handle()
    {
        $key_input = $this->argument('key');
        $tag_key = '';
        $hash_key = hash('sha256', '4bcfa16885bc2cde6c1fd0f759dece07407c20ca18cdcbc5f5cb4e333b4e3477');
        $key_cipher = AES::encrypt($key_input, $hash_key, $tag_key);

        $tag_key_base64 = base64_encode($tag_key);

        Key::firstOrCreate([
            'key' => $key_cipher,
            'tag_key' => $tag_key_base64
        ]);
    }
}
