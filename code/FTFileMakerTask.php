<?php
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

/**
 * Creates sample folder and file structure, useful to test performance,
 * UI behaviour on deeply nested structures etc.
 *
 * Downloads around 20MB of data from a public web location on first run,
 * in order to create reasonable fixture data (and keep it out of the module repo).
 * The related AWS S3 bucket is managed by SilverStripe Ltd.
 *
 * Protip: In case you want to test thumbnail generation, you can
 * recursively delete any generated ones through the following bash command in `assets/`:
 * `find . -name '*Resampled*' -print0 | xargs -0 rm`
 *
 * Parameters:
 *  - reset=1: Optionally truncate ALL files and folders in the database, plus delete
 *    the entire `assets/` directory.
 *
 * @todo Automatically retrieve file listing from S3
 * @todo Handle HTTP errors from S3
 */
class FTFileMakerTask extends BuildTask
{

    protected $fixtureFileBaseUrl = "https://s3-ap-southeast-2.amazonaws.com/silverstripe-frameworktest-assets/";

    protected $defaultImageFileName = 'image-huge-tall.jpg';

    protected $fixtureFileNames = [
        'archive.zip',
        'animated.gif',
        'document.docx',
        'document.pdf',
        'image-huge-tall.jpg',
        'image-huge-wide.jpg',
        'image-large.jpg',
        'image-large.png',
        'image-large.gif',
        'image-medium.jpg',
        'image-small.jpg',
        'image-tiny.jpg',
        'image-medium.bmp',
        'spreadsheet.xlsx',
        'video.m4v'
    ];

    protected $fixtureFileTypes = [
        'archive.zip' => 'File',
        'animated.gif' => 'Image',
        'document.docx' => 'File',
        'document.pdf' => 'File',
        'image-huge-tall.jpg' => 'Image',
        'image-huge-wide.jpg' => 'Image',
        'image-large.jpg' => 'Image',
        'image-large.png' => 'Image',
        'image-large.gif' => 'Image',
        'image-medium.jpg' => 'Image',
        'image-small.jpg' => 'Image',
        'image-tiny.jpg' => 'Image',
        'image-medium.bmp' => 'File',
        'spreadsheet.xlsx' => 'File',
        'video.m4v' => 'File',
    ];

    protected $folderCountByDepth = [
        0 => 1,
        1 => 20,
        2 => 2,
        3 => 2,
        4 => 2,
    ];

    protected $fileCountByDepth = [
        0 => 20,
        1 => 5,
        2 => 5,
        3 => 5,
        4 => 5,
    ];

    /**
     * @var int Constrained by elements in $folderCountByDepth and $fileCountByDepth
     */
    protected $depth = 1;

    public function run($request)
    {
        if ($request->getVar('reset')) {
            $this->reset();
        }

        echo "Downloading fixtures\n";
        $fixtureFilePaths = $this->downloadFixtureFiles();

        echo "Generate thumbnails\n";
        $this->generateThumbnails($fixtureFilePaths);

        echo "Generate files\n";
        $this->generateFiles($fixtureFilePaths);

        if (class_exists('SecureFileExtension')) {
            echo "Generate protected files\n";
            $this->generateProtectedFiles($fixtureFilePaths);
        }
    }

    protected function reset()
    {
        echo "Resetting assets\n";

        DB::query('TRUNCATE "File"');
        DB::query('TRUNCATE "File_Live"');
        DB::query('TRUNCATE "File_versions"');

        if (file_exists(ASSETS_PATH) && ASSETS_PATH && ASSETS_PATH !== '/') {
            exec("rm -rf " . ASSETS_PATH);
        }
    }

    protected function downloadFixtureFiles()
    {
        $client = new Client(['base_uri' => $this->fixtureFileBaseUrl]);

        // Initiate each request but do not block
        $promises = [];
        $paths = [];
        foreach ($this->fixtureFileNames as $filename) {
            $path = TEMP_FOLDER . '/' . $filename;
            $paths[$filename] = $path;
            $url = "{$this->fixtureFileBaseUrl}/{$filename}";
            if (!file_exists($path)) {
                $promises[$filename] = $client->getAsync($filename, [
                    'sink' => $path
                ]);
                echo "Downloading $url\n";
            }
        }

        // Wait on all of the requests to complete. Throws a ConnectException
        // if any of the requests fail
        Promise\unwrap($promises);

        return $paths;
    }

    /**
     * Creates protected files, if silverstripe/secureassets is installed.
     * Note that in this module, only folders can be protected (and all files within them).
     *
     * @param array $fixtureFilePaths
     */
    protected function generateProtectedFiles($fixtureFilePaths)
    {
        $folder = Folder::find_or_make('testfolder-protected');
        $fileName = $this->defaultImageFileName;

        copy($fixtureFilePaths[$fileName], $folder->getFullPath() . $fileName);

        $contentAuthorsGroup = DataObject::get('Group')
            ->filter('Code', 'content-authors')
            ->First();

        if (!$contentAuthorsGroup) {
            throw new LogicException('No content authors group found');
        }

        $folder->CanViewType = 'OnlyTheseUsers';
        $folder->ViewerGroups()->add($contentAuthorsGroup);
        $folder->write();

        $file = new Image([
            'ParentID' => $folder->ID,
            'Title' => $fileName,
            'Name' => $fileName,
            'Filename' => $folder->getRelativePath() . $fileName,
        ]);
        $file->write();
    }

    /**
     * Creates thumbnails of sample images
     *
     * @param array $fixtureFilePaths
     */
    protected function generateThumbnails($fixtureFilePaths)
    {
        $folder = Folder::find_or_make('testfolder-thumbnail');
        $fileName = $this->defaultImageFileName;

        copy($fixtureFilePaths[$fileName], $folder->getFullPath() . $fileName);

        $file = new Image([
            'ParentID' => $folder->ID,
            'Title' => $fileName,
            'Name' => $fileName,
            'Filename' => $folder->getRelativePath() . $fileName,
        ]);
        $file->write();

        $file->Pad(60,60)->CropHeight(30);
    }

    protected function generateFiles($fixtureFilePaths, $depth = 0, $prefix = "0", $parentID = 0)
    {
        $folderCount = $this->folderCountByDepth[$depth];
        $fileCount = $this->fileCountByDepth[$depth];

        $parent = $parentID ? DataObject::get_by_id('Folder', $parentID) : null;
        $parentPath = $parent ? preg_replace('#^' . ASSETS_DIR . '#', '', $parent->getRelativePath()) : '';
        for ($i=1; $i<=$folderCount; $i++) {
            $folder = Folder::find_or_make($parentPath . "/testfolder-{$prefix}{$i}");
            echo "\n";
            echo "Created Folder: '$folder->Title'\n";

            for ($j=1; $j<=$fileCount; $j++) {
                $randomFileName = array_keys($fixtureFilePaths)[rand(0, count($fixtureFilePaths)-1)];
                $randomFilePath = $fixtureFilePaths[$randomFileName];

                $fileName = pathinfo($randomFilePath, PATHINFO_FILENAME)
                    . "-{$prefix}-{$j}"
                    . "."
                    . pathinfo($randomFilePath, PATHINFO_EXTENSION);

                // Add a random prefix to avoid all types of files showing up on a single screen page
                $fileName = substr(md5($fileName), 0, 5) . '-' . $fileName;

                $class = $this->fixtureFileTypes[$randomFileName];

                // Write file contents
                file_put_contents($folder->getFullPath() . $fileName, file_get_contents($randomFilePath));

                $file = new $class([
                    'ParentID' => $folder->ID,
                    'Title' => $fileName,
                    'Name' => $fileName,
                    'Filename' => $folder->getRelativePath() . $fileName,
                ]);
                $file->write();

                // Randomly set old created date (for testing)
                if (rand(0, 10) == 0) {
                    $file->Created = '2010-01-01 00:00:00';
                    $file->Title = '[old] ' . $file->Title;
                    $file->write();
                }

                echo "  Created File: '$file->Title'\n";
            }

            if ($depth < $this->depth) {
                $this->generateFiles($fixtureFilePaths, $depth+1, "{$prefix}-{$i}", $folder->ID);
            }
        }
    }

}
