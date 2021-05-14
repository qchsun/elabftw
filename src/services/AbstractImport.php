<?php
/**
 * @package   Elabftw\Elabftw
 * @author    Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2012 Nicolas CARPi
 * @license   https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0
 * @see       https://www.elabftw.net Official website
 */
declare(strict_types=1);

namespace Elabftw\Services;

use Elabftw\Elabftw\Db;
use Elabftw\Exceptions\ImproperActionException;
use Elabftw\Models\Users;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mother class of ImportCsv and ImportZip
 */
abstract class AbstractImport
{
    protected Db $Db;

    protected UploadedFile $UploadedFile;

    // the item type category or userid where we do the import
    protected int $target;

    // read permission for the imported items
    protected string $canread;

    public function __construct(protected Users $Users, Request $request)
    {
        $this->Db = Db::getConnection();
        $this->target = (int) $request->request->get('target');
        $this->canread = Check::visibility($request->request->get('visibility') ?? '');
        $this->UploadedFile = $request->files->all()['file'];
        if ($this->UploadedFile->getError()) {
            throw new ImproperActionException($this->UploadedFile->getErrorMessage());
        }

        $this->checkMimeType();
    }

    /**
     * Look at mime type. not a trusted source, but it can prevent dumb errors
     * There is null in the mimes array because it can happen that elabftw files are like that.
     */
    protected function checkMimeType(): bool
    {
        $mimes = array(
            null,
            'application/csv',
            'application/vnd.ms-excel',
            'text/plain',
            'text/csv',
            'text/tsv',
            'application/zip',
            'application/force-download',
            'application/x-zip-compressed',
        );

        if (in_array($this->UploadedFile->getMimeType(), $mimes, true)) {
            return true;
        }
        throw new ImproperActionException("This doesn't look like the right kind of file. Import aborted.");
    }
}
