<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;
use App\Models\Histories;
use App\Jobs\ImportChat;
use App\Jobs\RequestChat;
use App\Models\Chats;
use App\Models\LLMs;
use App\Models\Bots;
use App\Models\User;
use App\Models\Feedback;
use DB;
use Session;

class BotController extends Controller
{
    function modelfile_parse($data)
    {
        $commands = [];
        $currentCommand = [
            'Name' => '',
            'Args' => '',
        ];

        $systemCommandProcessed = false; // Flag to track if a system command has been processed

        // Split the input data into lines
        $lines = explode("\n", $data);

        // Iterate over each line
        foreach ($lines as $line) {
            // Trim whitespace from the beginning and end of the line
            $line = trim($line);

            // If the line is empty, skip it
            if (!$line) {
                continue;
            }

            // Check if the line starts with a command keyword
            if (strtoupper(substr($line, 0, 4)) === 'FROM' || strtoupper(substr($line, 0, 7)) === 'ADAPTER' || strtoupper(substr($line, 0, 7)) === 'LICENSE' || strtoupper(substr($line, 0, 8)) === 'TEMPLATE' || strtoupper(substr($line, 0, 6)) === 'SYSTEM' || strtoupper(substr($line, 0, 9)) === 'PARAMETER' || strtoupper(substr($line, 0, 7)) === 'MESSAGE') {
                // If a command is already being accumulated, push it to the commands array
                if ($currentCommand['Name'] !== '' && trim($currentCommand['Args']) !== '') {
                    $commands[] = $currentCommand;
                }
                // Start a new command
                $currentCommand = [
                    'Name' => '',
                    'Args' => '',
                ];

                // Split the line into command type and arguments
                $commandParts = preg_split('/\s+(.+)/', $line, -1, PREG_SPLIT_DELIM_CAPTURE);
                $commandType = $commandParts[0];
                $commandArgs = isset($commandParts[1]) ? $commandParts[1] : '';

                // Set the current command's name and arguments
                $currentCommand['Name'] = strtolower($commandType);
                $currentCommand['Args'] = trim($commandArgs);

                // If the command is a system command and it has already been processed, skip it
                if ($currentCommand['Name'] === 'system' && $systemCommandProcessed) {
                    $currentCommand = [
                        'Name' => '',
                        'Args' => '',
                    ];
                } elseif ($currentCommand['Name'] === 'system') {
                    $systemCommandProcessed = true; // Set the flag to true if a system command is processed
                }
            } else {
                // If the line does not start with a command keyword, append it to the current command's arguments
                $currentCommand['Args'] .= "\n" . $line;
            }
        }

        // Push the last command to the commands array if it has non-empty arguments
        if ($currentCommand['Name'] !== '' && trim($currentCommand['Args']) !== '') {
            $commands[] = $currentCommand;
        }

        // Remove triple-quotes at the start or end of arguments
        foreach ($commands as &$command) {
            if (strpos($command['Args'], '"""') === 0) {
                $command['Args'] = substr($command['Args'], 3);
            }
            if (strrpos($command['Args'], '"""') === strlen($command['Args']) - 3) {
                $command['Args'] = substr($command['Args'], 0, -3);
            }
        }

        return $commands;
    }

    public function home(Request $request)
    {
        return view('store');
    }
    public function create(Request $request)
    {
        $model_id = LLMs::where('name', '=', $request->input('llm_name'))->first()->id;
        if ($model_id) {
            $bot = new Bots();
            $config = [];
            if ($request->input('modelfile')) {
                $config['modelfile'] = $this->modelfile_parse($request->input('modelfile'));
            }
            if ($request->input('react_btn')) {
                $config['react_btn'] = $request->input('react_btn');
            }
            $config = json_encode($config);
            $bot->fill(['name' => $request->input('bot-name'), 'type' => 'prompt', 'visibility' => 1, 'description' => $request->input('bot-describe'), 'owner_id' => $request->user()->id, 'model_id' => $model_id, 'config' => $config]);
            $bot->save();
        }

        return redirect()->route('store.home');
    }
    public function update(Request $request)
    {
        return redirect()->route('store.home');
    }
    public function delete(Request $request): RedirectResponse
    {
        $bot = Bots::findOrFail($request->input("id")); 
        if ($bot->image) Storage::delete($bot->image);
        $bot->delete();
        return Redirect::route('store.home');
    }
}
