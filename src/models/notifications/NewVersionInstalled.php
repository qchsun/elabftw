<?php declare(strict_types=1);
/**
 * @author Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2024 Nicolas CARPi
 * @see https://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */

namespace Elabftw\Models\Notifications;

use Elabftw\Enums\Notifications;

class NewVersionInstalled extends AbstractNotifications
{
    protected Notifications $category = Notifications::NewVersionInstalled;
}
