<?php declare(strict_types=1);
/**
 * This file is part of laravel.ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Psr\Log\LoggerInterface;

/**
 * Class UploadAvatarProcess
 * @package App\Jobs
 */
class UploadAvatarProcess implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    private const GRAVATAR_URL = 'https://www.gravatar.com/avatar/%s?default=404';

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $gravatarUrl;

    /**
     * Create a new job instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $hash = md5(strtolower(trim($this->user->email)));

        $this->gravatarUrl = sprintf(self::GRAVATAR_URL, $hash);
    }

    /**
     * @param ImageManager $manager
     * @param Client $client
     */
    public function handle(ImageManager $manager, Client $client): void
    {
        try {
            $client->head($this->gravatarUrl);

            $avatarName = md5(random_int(0, 9999) . $this->user->email) . '.png';

            $manager->make($this->gravatarUrl)
                ->resize(64, null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->crop(64, 64)
                ->save(public_path(User::DEFAULT_AVATAR_PATH . $avatarName));

        } catch (ClientException $exception) {
            $avatarName = User::DEFAULT_AVATAR_NAME;
        }

        $this->user->avatar = $avatarName;
        $this->user->save();
    }
}
