<?php

namespace IanM\BoringAvatars\Console;

use Flarum\Bus\Dispatcher;
use Flarum\User\User;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar;
use Illuminate\Console\Command;

class GenerateBoringAvatars extends Command
{
    protected $signature = 'boringavatars:generate {--force : Generate avatars for all users regardless of their current state}';
    protected $description = 'Generates Boring Avatars for all users based on the current settings.';

    protected $updateCount = 0;
    protected $notRequired = 0;

    public function __construct(public Dispatcher $bus)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Generating avatars. This may take some time if you have many users!');

        $this->output->progressStart(User::query()->count());

        User::query()->each(function (User $user) {
            // If the force option is used or the user doesn't have an avatar, generate one
            if ($this->option('force') || $user->user_svg === null) {
                if ($user->user_svg !== null) {
                    $user->user_svg = null;
                    $user->save();
                }
                $this->bus->dispatch(new GenerateAvatar($user, BoringAvatar::$defaultGenerationSize, BoringAvatar::$defaultSquareAvatar));
                $this->updateCount++;
            } else {
                $this->notRequired++;
            }

            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $this->info("Updated {$this->updateCount} users, {$this->notRequired} users did not need updating.");
    }
}
